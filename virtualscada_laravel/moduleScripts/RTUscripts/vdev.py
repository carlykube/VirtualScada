#!/usr/bin/env python

"""
@author Brad Reaves
February 2011
@version 0.1
@license GPL2
"""

#Built-in modules
import threading, Queue, time, socket, errno, code, os, logging
from pprint import pprint

#External modules
import simplejson as json
from configobj import ConfigObj
from optparse import OptionParser

#Project Modules
import protolibs.ifaces as ifaces
import protolibs.ics_clients as ics_clients
import protolibs.ics_servers as ics_servers
from point import Point


#--------------- Function Definitions ---------------------
def processUpdate(update):
    """processUpdate converts a JSON update string into Python data types
        
    @param update This parameter is a JSON message received from the interface
    @returns A dictionary of the message contents
    """
    update = json.loads(update)
    return update

    
def applyUpdate(update, state):
    """This function takes a dictionary corresponding to an update and 
       if the key corresponds to a state variable, the state variable is set to
       the value in the update.

       @param update Dictionary derived from an update message.
       @param state The state dictionary for the process simulation
       """
    for var in update.keys():
        if var in state.keys():
            if state[var].typ is Point.INPUT:
                state[var].set(update[var])
            elif state[var].typ is Point.OUTPUT:
                pass
        elif var == "simtime":
            pass
        else:
            #log the error
            #TODO: Change to a logger
            print "Unknown process variable in update:: %s : %s" % \
                  ( str(var), str(update[var]) )

def compileUpdate(state):
    """This function creates a JSON string of all output
        points and the current time.

       @param state The dictionary of device points.
       @returns A string containing the JSON representation of the
                    output variables.
       """
    updateDict = {}
    #Get each point out of the 'simname:point' dictionary
    for pt in state.values():
        if pt.typ is Point.OUTPUT: #'Update only the outputs
            updateDict[ pt.name ] = pt.get()
    updateDict['updatetime'] = time.time()

    update = json.dumps(updateDict) 
    return update

#--------------- Module-scope variables -------------------


#Queue object used to pass updates from simulation and PCS interfaces to the
#   logic thread
updateQ = Queue.Queue()

#List of all thread objects to be run. Allows code to support an arbitrary
#   number of interfaces
threadList = [] 

#Module variable to store the device configuration from the config file
config = None
devconfig = None # this value is set in main()

#Dictionary containing this devices points. They are indexed by simulation name.
points = {}

#-------------- Thread definitions -------------------------

def logic(procControl, interface):
    """This function is a thread that arbitrates receiving updates from the
        simulator and other devices. Those update messages are used to update
        the device points. Once the points are updated, the process control
        logic function for this device is run. An update is generated as a
        result and passed to the simulator
        
        @param procControl  function object representing the process control
                            logic. 
        @param interface    iface to the simulator. Used for returning updates.
        """
    clients = {}
    master_name= devconfig['name']
    for dev in config['vdevs'].values():
        slave_name = dev['name']
        if slave_name == master_name: #Don't create a loop-back client
            continue
        new_client = ics_clients.ICSClientFactory(config, slave_name,
                                                               master_name)
        clients[dev['name']] = new_client

#ZACH: first, create an empty array of clients. Then, read the master name from the config file. For each device in the config file except the master, create a client. 
# 	Then, add this client to the array of clients

    while True:
        ##Use queue to arbitrate thread running
        ##updates and commands will come from both the simulator and the 
        ##PCS simulators

        try:
            update = updateQ.get(block=True, timeout=devconfig['timeout'])
            ##Apply update -- should only change inputs
            applyUpdate(update, points)
    
        except Queue.Empty:
            pass # get() timed out -- there's no update to get()

        ##Run process logic
        procControl(points, clients) 

        ##Compile update
        update = compileUpdate(points)
        
        ##Send update
        interface.sendMessage(update)

        while not updateQ.empty():
            try:
                update = updateQ.get(block=True, timeout=devconfig['timeout'])
                ##Apply update -- should only change inputs
                applyUpdate(update, points)
        
                ##Run process logic
                procControl(points, clients) 

                ##Compile update
                update = compileUpdate(points)
                
                ##Send update
                interface.sendMessage(update)
            except Queue.Empty:
                #This should probably never happen...
                break # get() timed out -- there's no more updates to get()

        ##Wait a bit so we aren't polling like crazy
        time.sleep(.05)
        
def simComm(interface):
    """Thread for receiving update messages from the simulator.

        @param interface The iface connected to the simulator.
        """
    while True:
        ##Wait on receiving updates
        updateMsg = interface.getMessage(block=True)

        ##Process Update 
        try:
            update=processUpdate(updateMsg)
        except ValueError: #Exceptions are thrown if the msg was not valid
            #TODO: Log here
            updateMsg=interface.getMessage(block=False)
            continue
        except TypeError:
            #TODO: Log here
            updateMsg=interface.getMessage(block=False)
            continue
        updateQ.put(update)
        
       
#------------- "Main" code --------------------------------
if __name__ == "__main__":
    ##--Parse command line options
    programDescription = """This program implements a virtual ICS device."""
    parser = OptionParser(description=programDescription)
    parser.add_option('-s', '--system', help="""Name of the system being simulated.\
            This name determines which configuration file is used.""", 
             action='store', default = 'tcptank')
    parser.add_option('-d', '--device', help="""Name of the device to implement.\
            This name is given in the configuration file for the simulation.""", 
             action='store', default = 'slave')

#ZACH:	Python has a built in optionparser object that is used to parse command line options. Above, the "-s" and "-d" options are created for the system and 		device

    #Get system and vdev name
    (opts, args) = parser.parse_args()
    vdevname = opts.device
    system = opts.system

#ZACH:	The two options are read in from the command line arguements and stored as "vdevname" and "system". We now what system(such as tcppipe) and what virtual device
#	(master or slave) we are using

    ##--Open config. 
    configfile = '/'.join(['sims', system, 'config'])
    #config is also a module-scoped variable
    config=ConfigObj(infile=configfile, unrepr=True)
    #Set module-scope variable devconfig here 
    devconfig=config['vdevs'][vdevname] 

#ZACH:	The config file for the particular simulation is opened as a file.  The config file contains all the information necessary for startup.
#	An object called "devconfig" is created to store the parameters from the config file for the particular device(master/slave).	

    ##--Set up points
    for p in devconfig['points']:
        points.update( { p['name'] : Point(**p) } ) 
        #The ** treats the p dictionary as the arguments to the Point class

#ZACH:	for all the points in the config file, call the update function for that point. Points are a class defined in the  /trunk/point.py file. The update function is 
# 	also defined there. This basically creates a Point object with all the points from the config file

    ##--Create simcomm thread
    simiface = None
    ifaceinfo = devconfig['simiface']
    if ifaceinfo:
        ifacetype = getattr(ifaces, ifaceinfo['typ']) #get a class object to construct
        simiface = ifacetype(**ifaceinfo)
        if ifaceinfo['typ'] != 'virtual':
            #We only want to poll ifaces that do things
            simiface.initialize()
            simifaceThread = threading.Thread(target=simComm, name=simiface, 
                                                args=(simiface,))
            threadList.append(simifaceThread)

#ZACH:	First, pull the simulator interface information from the config file and store it in "ifaceinfo". If non-zero, return a class object from the "/protolibs/ifaces.py" 
#	file to be constructed. Then construct an ifaces object corresponding to the interface defined in the config file(such as UDP or virtual) called "simiface". If the interface is 
#	not virutal, call the initialize funtion, create a thread for the local "simComm" function such that this function will run in a thread, then append the thread list with this #	thread. The idea here is that receiving messages on any interaface type is run in a thread so that they won't be missed. Keeps from having to use a stupid constant polling 
#	paradigm.

    ##--Create ICS Comm Threads
    for ifaceinfo in devconfig['icsifaces']:
        #create interface
        ifacetype = getattr(ics_servers, ifaceinfo['typ'])
        icsiface = ifacetype(ifaceinfo, points.values())
        threadList.append(icsiface) # icsifaces have start() and stop() like threads

#ZACH: Create an ICSserver object of the type defined in the icsiface config file section of type 'typ'(ModbusTCP or ModbusRTU).
#	 Create a Modbus object with all the 'icsifaces' information from the config file, and the points that were created. This basically 
#	creates for us a Modbus Server with all the points defined from the config file. This is then appended to the threadlist.   


    ##--Create logic thread
    #get sim logic from model
    exec 'from sims.'+system+'.vdevs import ' + vdevname + ' as procControl'
    #create thread
    logicThread = threading.Thread(target=logic, name = 'logicThread', args=(procControl, simiface))
    threadList.append(logicThread)

#ZACH:	imports the particular process VDEV file(which is basically the control logic of the particular process(tank,pipe,etc)). Then creates a thread 	calling the local "logic" 
#	function with the process VDEV and the procotol interface "simiface" (UDP,TCP, etc) as arguements. Then adds this to the threa list 

    ##--Start all threads
    for t in threadList:
        t.start()
    
    ##--For the user interface:
    def q(): os._exit(0)
    def shwpts(): pprint(points)
    def shwwtr(): pprint([points[k] for k in points if 'Water2' in k])
    def waterstart():
        points['MstrWWater2SystemMode'].set(2)

    def gasstart(): 
        #TODO: Not for final release. This is a helpful function for testing the
        #RTU pipeline.
        points['MstrWGasControlPump/Sol'].set(1); 
        points['MstrWGasSystemMode'].set(2)
    def halp():
        string = "This is a Python interpreter. Type:\n" +\
                        "shwpts()\t for \t List of all points and value\n" +\
                        "q()\t to \t Kill all threads and exit"
        print string


    #--Start the user interface
    banner = """Virtual Device [%s]. Type halp() for info""" % vdevname
    code.interact(local=locals(), banner=banner)
    