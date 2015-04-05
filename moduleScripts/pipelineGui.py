import modbus_tk
import modbus_tk.defines as cst
import modbus_tk.modbus_tcp as modbus_tcp
#for the MODBUS float conversion
from struct import *
#GUI
from Tkinter import * #had to install python-tk
#for sleeping
import time
import csv
import datetime 
import string
#from pylab import * #had to install 

def modbusRead(master):
#this function reads in all my MODBUS registers and coils, stores them in a class called "Variables".It returns "Variables"

	#unitID, functionCode,StartingRegister,#ofRegisters
	coils1 = master.execute(4, cst.READ_COILS, 5, 2)
	coils2 = master.execute(4, cst.READ_COILS, 100, 9)    
	regs1 = master.execute(4, cst.READ_HOLDING_REGISTERS, 43000, 8)
	regs2 = master.execute(4, cst.READ_HOLDING_REGISTERS, 43050,17)
	regs3 = master.execute(4, cst.READ_HOLDING_REGISTERS,44000,34)

	class Values:
		PumpRunCmd = coils1[0]
		SolOpenCmd = coils1[1]
		ControlPumpSol = coils2[0]
		SystemInMAN = coils2[1]
		SystemInAUTO = coils2[2]
		MANPumpRunCmd = coils2[3]
		MANSolOpenCmd = coils2[4]
		PIDIncrease = coils2[5]
		PIDDecrease = coils2[6]
		AUTOPumpRunCmd = coils2[7]
		AUTOSolOpenCmd = coils2[8]
		MstrRDigIn = regs1[1]
 		MstrRPressureInRaw = regs1[2]
		MstrRAnalogIn1 = regs1[3]
		MstrRAnalogIn2 = regs1[4]
	 	MstrRAnalogIn3 = regs1[5]
	 	MstrRAnalogIn4 = regs1[6]
		MstrRPressureScaled = regs1[7]
		MstrWControlPumpSol = regs2[0]
		MstrWSystemMode = regs2[1] 
		MstrWMANPumpCmd = regs2[2]
		MstrWMANSolCmd = regs2[3]
		MstrWNothing1 = regs2[4]
		MstrWNothing2 = regs2[5]
		MstrWPIDSetpoint = unpack('f',pack('<HH',regs2[7],regs2[6]))
		MstrWPIDGain = unpack('f',pack('<HH',regs2[9],regs2[8]))
		MstrWPIDResetRate = unpack('f',pack('<HH',regs2[11],regs2[10]))
		MstrWPIDRate = unpack('f',pack('<HH',regs2[13],regs2[12]))
		MstrWPIDDeadband = unpack('f',pack('<HH',regs2[14],regs2[13]))
		MstrWPIDCycleTime = unpack('f',pack('<HH',regs2[16],regs2[15]))	
		PIDPressureScaled = unpack('f',pack('<HH',regs3[1],regs3[0]))
		PIDSetpoint = unpack('f',pack('<HH',regs3[3],regs3[2]))
		PIDGain = unpack('f',pack('<HH',regs3[5],regs3[4]))
		PIDResetRate = unpack('f',pack('<HH',regs3[7],regs3[6]))
		PIDRate = unpack('f',pack('<HH',regs3[9],regs3[8]))
		PIDDeadband = unpack('f',pack('<HH',regs3[11],regs3[10]))
		dPIDFullPercent = unpack('f',pack('<HH',regs3[13],regs3[12]))
		PIDZeroPercent = unpack('f',pack('<HH',regs3[15],regs3[14]))
		PIDCycleTime = unpack('f',pack('<HH',regs3[17],regs3[16]))
		PIDManualModeOutput = unpack('f',pack('<HH',regs3[19],regs3[18]))
		MotorOutputEnabled = unpack('f',pack('<HH',regs3[21],regs3[20]))
		PIDOutputPercent = unpack('f',pack('<HH',regs3[23],regs3[22]))
		PIDOldProcessValue = unpack('f',pack('<HH',regs3[25],regs3[24]))
		PIDOlderProcessValue = unpack('f',pack('<HH',regs3[27],regs3[26]))
		PIDOldErrorValue = unpack('f',pack('<HH',regs3[29],regs3[28]))
		PIDLastScanTime = unpack('f',pack('<HH',regs3[31],regs3[30]))
		PIDOnTime = unpack('f',pack('<HH',regs3[33],regs3[32]))
	return Values

def modbusWrite(master,theNewValues):
#this function does my MODBUS writing. It should only write PID setpoint, gain, reset, rate, system mode, control mode, pump, and solenoid	
#it converts floats into two 16bit hex values for MODBUS transmission
#it also checks and only writes when the user changes the value
			
	newSP = theNewValues.setpoint	
	i1, i2 = unpack('<HH',pack('f',newSP))	
	if(theNewValues.setpoint != theOldValues.setpoint):
		master.execute(4, cst.WRITE_MULTIPLE_REGISTERS, 43056, output_value=(i2,i1)) 
		theOldValues.setpoint = theNewValues.setpoint
	
	newGain = theNewValues.gain
	i1, i2 = unpack('<HH',pack('f',newGain))
	if(theNewValues.gain != theOldValues.gain):
		master.execute(4, cst.WRITE_MULTIPLE_REGISTERS, 43058, output_value=(i2,i1)) 
		theOldValues.gain = theNewValues.gain

	newReset = theNewValues.reset
	i1, i2 = unpack('<HH',pack('f',newReset))
	if(theNewValues.reset != theOldValues.reset):
		master.execute(4, cst.WRITE_MULTIPLE_REGISTERS, 43060, output_value=(i2,i1)) 
		theOldValues.reset = theNewValues.reset

	newRate = theNewValues.rate
	i1, i2 = unpack('<HH',pack('f',newRate))
	if(theNewValues.rate != theOldValues.rate):
		master.execute(4, cst.WRITE_MULTIPLE_REGISTERS, 43062, output_value=(i2,i1)) 
		theOldValues.rate = theNewValues.rate		
			
	newControl = theNewValues.control
	newMode = theNewValues.mode	
	if(theNewValues.control != theOldValues.control or theNewValues.mode != theOldValues.mode):
		master.execute(4, cst.WRITE_MULTIPLE_REGISTERS, 43050, output_value=(newControl,newMode)) 
		theOldValues.control = theNewValues.control
		theOldValues.mode = theNewValues.mode	

	newPump = theNewValues.pump
	newSol = theNewValues.solenoid	
	if(theNewValues.pump != theOldValues.pump or theNewValues.solenoid != theOldValues.solenoid):
		master.execute(4, cst.WRITE_MULTIPLE_REGISTERS, 43052, output_value=(newPump,newSol)) 
		theOldValues.pump = theNewValues.pump
		theOldValues.solenoid = theNewValues.solenoid

def guiInit(Values):
#graphics initialization code. This function creates the static elements, and dynamic ones and returns the guiObjects class for the dynamic objects	
	
	#turning reset, and rate into rounded floats and turning the mode and control values into strings
	round1 = round(float(Values.PIDResetRate[0]),2)
	string1 = float(round1)
	round2 = round(float(Values.PIDRate[0]),2)
	string2 = float(round2)
	round3 = round(float(TheValues.PIDPressureScaled[0]),2)
	string5 = float(round3)
	round4 = round(float(TheValues.PIDSetpoint[0]),2)
	string6 = float(round4)
	round5 = round(float(TheValues.PIDGain[0]),2)
	string7 = float(round5)
	if(Values.MstrWSystemMode == 0):
		string3 = "OFF"
	elif(Values.MstrWSystemMode == 1):
		string3 = "MAN"
	elif(Values.MstrWSystemMode == 2):
		string3 = "AUTO"
	else:
		string3 = "?"
	if(Values.MstrWControlPumpSol == 0):
		string4 = "PUMP"
	elif(Values.MstrWControlPumpSol == 1):
		string4 = "SOL"
	else:
		string4 = "?"

	#dynamic elements to be used elsewhere
	class guiObjects:
		master = Tk()
		w = Canvas(master, width=2000, height=2000, background="white")	
		w.create_rectangle(60,750, 200, 800, fill="grey")	
		 #xStart,yStart,xStop,yStart
		pumpOval =w.create_oval(160,700, 260, 800, fill="red", outline = "red")
		pumpRect = w.create_rectangle(199,705, 299, 750, fill="red",outline = "red")
		valve1 = w.create_polygon(1000,700,1030,730,1000,760 ,fill="red",outline = "black")
		valve2 = w.create_polygon(1060,700,1030,730,1060,760 ,fill="red",outline = "black")
		valve3 = w.create_rectangle(1028,680, 1032, 730, fill="red", outline = "black")
		valve4 = w.create_rectangle(1000,660, 1060, 680, fill="red", outline = "black")
		psi = w.create_text(100,50,text=string5)
		setpoint = w.create_text(100,70,text=string6)
		gain = w.create_text(100,90,text=string7)
		reset = w.create_text(100,110,text=string1)	
		rate = w.create_text(100,130,text=string2)
		mode = w.create_text(100,150,text=string3)
		control = w.create_text(100,180,text=string4)
		setpointEntry = Entry(master, width=5)
		gainEntry = Entry(master, width=5)
		resetEntry = Entry(master, width=5)
		rateEntry = Entry(master, width=5)
		offButton = Button(master, text="OFF", command=modeOff)
		manButton = Button(master, text="MAN", command=modeMan)
		autoButton = Button(master, text="AUTO", command=modeAuto)
		pumpButton = Button(master, text="PUMP", command=controlPump)
		solButton = Button(master, text="SOL", command=controlSol)
		pumpOffButton = Button(master, text="OFF", command=pumpOff)
		pumpOnButton = Button(master, text="ON", command=pumpOn)
		solCloseButton = Button(master, text="CLOSE", command=solClose)
		solOpenButton = Button(master, text="OPEN", command=solOpen)
		bubble1 = w.create_oval(1070,640, 1080, 650, fill="white", outline = "white")
		bubble2 = w.create_oval(1090,620, 1110, 640, fill="white", outline = "white")
		bubble3 = w.create_oval(1120,580, 1150, 610, fill="white", outline = "white")
		caution = w.create_polygon(1000,50,1100,50,1200,150,1200,250,1100,350,1000,350,900,250,900,150,1000,50, fill="white",outline = "white")
		highPressure1 = w.create_text(1050,150,text="",font = ("Times",24))
		highPressure2 = w.create_text(1050,200,text="",font = ("Times",24))

	#static elements
	guiObjects.w.create_rectangle(300,705, 1000, 750, fill="grey")
	guiObjects.w.create_rectangle(300,705, 350, 300, fill="grey")
	guiObjects.w.create_rectangle(300,300, 1400, 350, fill="grey")
	guiObjects.w.create_rectangle(1400,300, 1450, 705, fill="grey")	
	guiObjects.w.create_rectangle(1060,705, 1570, 750, fill="grey")
	guiObjects.w.create_text(210,730,text="gas")
	guiObjects.w.create_text(210,740,text="pump")
	guiObjects.w.create_text(1030,665,text="solenoid")
	guiObjects.w.create_text(1030,675,text="valve")
	guiObjects.w.create_text(30,50,text="PSI:")
	guiObjects.w.create_text(30,70,text="Setpoint:")
	guiObjects.w.create_text(30,90,text="Gain:")
	guiObjects.w.create_text(30,110,text="Reset:")
	guiObjects.w.create_text(30,130,text="Rate:")
	guiObjects.w.create_text(40,150,text="SystemMode")
	guiObjects.w.create_text(40,180,text="ControlMode")
	guiObjects.w.create_text(40,210,text="Pump")
	guiObjects.w.create_text(40,240,text="Solenoid")
	guiObjects.setpointEntry.pack()	
	guiObjects.w.create_window(120, 60, anchor=NW, window=guiObjects.setpointEntry)
	guiObjects.w.create_window(120, 80, anchor=NW, window=guiObjects.gainEntry)
	guiObjects.w.create_window(120, 100, anchor=NW, window=guiObjects.resetEntry)
	guiObjects.w.create_window(120, 120, anchor=NW, window=guiObjects.rateEntry)
	guiObjects.w.create_window(120, 140, anchor=NW, window=guiObjects.offButton)
	guiObjects.w.create_window(170, 140, anchor=NW, window=guiObjects.manButton)
	guiObjects.w.create_window(225, 140, anchor=NW, window=guiObjects.autoButton)
	guiObjects.w.create_window(120, 170, anchor=NW, window=guiObjects.pumpButton)
	guiObjects.w.create_window(170, 170, anchor=NW, window=guiObjects.solButton)
	guiObjects.w.create_window(120, 200, anchor=NW, window=guiObjects.pumpOffButton)
	guiObjects.w.create_window(170, 200, anchor=NW, window=guiObjects.pumpOnButton)
	guiObjects.w.create_window(120, 230, anchor=NW, window=guiObjects.solCloseButton)
	guiObjects.w.create_window(180, 230, anchor=NW, window=guiObjects.solOpenButton)
	guiObjects.w.pack()
	
	return guiObjects

def redrawGui(TheValues):
#this function redraws the variable elements of the gui
	
	#turning reset, and rate into rounded floats and turning the mode and control values into strings
	round1 = round(float(TheValues.PIDResetRate[0]),2)
	string1 = float(round1)
	round2 = round(float(TheValues.PIDRate[0]),2)
	string2 = float(round2)
	round3 = round(float(TheValues.PIDPressureScaled[0]),2)
	string5 = float(round3)
	round4 = round(float(TheValues.PIDSetpoint[0]),2)
	string6 = float(round4)
	round5 = round(float(TheValues.PIDGain[0]),2)
	string7 = float(round5)

	if(TheValues.MstrWSystemMode == 0):
		string3 = "OFF"
	elif(TheValues.MstrWSystemMode == 1):
		string3 = "MAN"
	elif(TheValues.MstrWSystemMode == 2):
		string3 = "AUTO"
	else:
		string3 = "?"
	if(TheValues.MstrWControlPumpSol == 0):
		string4 = "PUMP"
	elif(TheValues.MstrWControlPumpSol == 1):
		string4 = "SOL"
	else:
		string4 = "?"
	
	#deleting the old objects
	TheGuiObjects.w.delete(TheGuiObjects.psi)
	TheGuiObjects.w.delete(TheGuiObjects.setpoint)
	TheGuiObjects.w.delete(TheGuiObjects.gain)
	TheGuiObjects.w.delete(TheGuiObjects.reset)
	TheGuiObjects.w.delete(TheGuiObjects.rate)
	TheGuiObjects.w.delete(TheGuiObjects.mode)
	TheGuiObjects.w.delete(TheGuiObjects.control)
	TheGuiObjects.w.delete(TheGuiObjects.pumpOval)
	TheGuiObjects.w.delete(TheGuiObjects.pumpRect)
	TheGuiObjects.w.delete(TheGuiObjects.valve1)
	TheGuiObjects.w.delete(TheGuiObjects.valve2)
	TheGuiObjects.w.delete(TheGuiObjects.valve3)
	TheGuiObjects.w.delete(TheGuiObjects.valve4)
	TheGuiObjects.w.delete(TheGuiObjects.bubble1)
	TheGuiObjects.w.delete(TheGuiObjects.bubble2)
	TheGuiObjects.w.delete(TheGuiObjects.bubble3)
	TheGuiObjects.w.delete(TheGuiObjects.highPressure1)
	TheGuiObjects.w.delete(TheGuiObjects.highPressure2)
	TheGuiObjects.w.delete(TheGuiObjects.caution)
	
	#creating new objects to draw
	TheGuiObjects.psi = TheGuiObjects.w.create_text(100,50,text=string5)
	TheGuiObjects.setpoint = TheGuiObjects.w.create_text(100,70,text=string6)
	TheGuiObjects.gain = TheGuiObjects.w.create_text(100,90,text=string7)
	TheGuiObjects.reset = TheGuiObjects.w.create_text(100,110,text=string1)
	TheGuiObjects.rate = TheGuiObjects.w.create_text(100,130,text=string2)
	TheGuiObjects.mode = TheGuiObjects.w.create_text(100,150,text=string3)
	TheGuiObjects.control = TheGuiObjects.w.create_text(100,180,text=string4)
	
	#checking if the pump is on or off. The color of the pump changes, depending on state
	if(TheValues.PumpRunCmd == 1):
		TheGuiObjects.pumpOval =TheGuiObjects.w.create_oval(160,700, 260, 800, fill="green", outline = "green")
		TheGuiObjects.pumpRect = TheGuiObjects.w.create_rectangle(199,705, 299, 750, fill="green",outline = "green")
	elif(TheValues.PumpRunCmd == 0):
		TheGuiObjects.pumpOval =TheGuiObjects.w.create_oval(160,700, 260, 800, fill="red", outline = "red")
		TheGuiObjects.pumpRect = TheGuiObjects.w.create_rectangle(199,705, 299, 750, fill="red",outline = "red")
	else:
		TheGuiObjects.pumpOval =TheGuiObjects.w.create_oval(160,700, 260, 800, fill="red", outline = "red")
		TheGuiObjects.pumpRect = TheGuiObjects.w.create_rectangle(199,705, 299, 750, fill="red",outline = "red")

	#checking if the valve is open or closed. The color of the valve changes, depending on state
	if(TheValues.SolOpenCmd == 1):
		TheGuiObjects.valve1 = TheGuiObjects.w.create_polygon(1000,700,1030,730,1000,760 ,fill="green",outline = "black")
		TheGuiObjects.valve2 = TheGuiObjects.w.create_polygon(1060,700,1030,730,1060,760 ,fill="green",outline = "black")
		TheGuiObjects.valve3 = TheGuiObjects.w.create_rectangle(1028,680, 1032, 730, fill="green", outline = "black")
		TheGuiObjects.valve4 = TheGuiObjects.w.create_rectangle(1000,660, 1060, 680, fill="green", outline = "black")
		TheGuiObjects.bubble1 = TheGuiObjects.w.create_oval(1070,640, 1080, 650, fill="white", outline = "black")
		TheGuiObjects.bubble2 = TheGuiObjects.w.create_oval(1090,620, 1110, 640, fill="white", outline = "black")
		TheGuiObjects.bubble3 = TheGuiObjects.w.create_oval(1120,580, 1150, 610, fill="white", outline = "black")
	elif(TheValues.SolOpenCmd == 0):
		TheGuiObjects.valve1 = TheGuiObjects.w.create_polygon(1000,700,1030,730,1000,760 ,fill="red",outline = "black")
		TheGuiObjects.valve2 = TheGuiObjects.w.create_polygon(1060,700,1030,730,1060,760 ,fill="red",outline = "black")
		TheGuiObjects.valve3 = TheGuiObjects.w.create_rectangle(1028,680, 1032, 730, fill="red", outline = "black")
		TheGuiObjects.valve4 = TheGuiObjects.w.create_rectangle(1000,660, 1060, 680, fill="red", outline = "black")
	else:
		TheGuiObjects.valve1 = TheGuiObjects.w.create_polygon(1000,700,1030,730,1000,760 ,fill="red",outline = "black")
		TheGuiObjects.valve2 = TheGuiObjects.w.create_polygon(1060,700,1030,730,1060,760 ,fill="red",outline = "black")
		TheGuiObjects.valve3 = TheGuiObjects.w.create_rectangle(1028,680, 1032, 730, fill="red", outline = "black")
		TheGuiObjects.valve4 = TheGuiObjects.w.create_rectangle(1000,660, 1060, 680, fill="red", outline = "black")
	if(round3 > 50):
		TheGuiObjects.caution = TheGuiObjects.w.create_polygon(1000,50,1100,50,1200,150,1200,250,1100,350,1000,350,900,250,900,150,1000,50, fill="red",outline = "black")
		TheGuiObjects.highPressure1 = TheGuiObjects.w.create_text(1050,150,text="High",font = ("Times",24))
		TheGuiObjects.highPressure2 = TheGuiObjects.w.create_text(1050,200,text="Pressure",font = ("Times",24))
		
	TheGuiObjects.w.create_text(210,730,text="gas")
	TheGuiObjects.w.create_text(210,740,text="pump")
	TheGuiObjects.w.create_text(1030,665,text="solenoid")
	TheGuiObjects.w.create_text(1030,675,text="valve")
	TheGuiObjects.w.pack()


def modeOff():
#a setter function so the OFF button will turn the mode to OFF
	theNewValues.mode = 0

def modeMan():
#a setter function so the MAN button will turn the mode to MAN	
	theNewValues.mode = 1

def modeAuto():
#a setter function so the AUTO button will turn the mode to AUTO		
	theNewValues.mode = 2

def controlPump():
#a setter function so the PUMP button will turn the control mode to PUMP		
	theNewValues.control = 0

def controlSol():
#a setter function so the SOL button will turn the control mode to SOL	
	theNewValues.control = 1

def pumpOff():
# a setter function so the OFF button will turn the pump OFF in MAN mode
	theNewValues.pump = 0

def pumpOn():
# a setter function so the OFF button will turn the pump OFF in MAN mode
	theNewValues.pump = 1	

def solClose():
# a setter function so the CLOSE button will close the solenoid in MAN mode
	theNewValues.solenoid = 0	

def solOpen():
# a setter function so the OPEN button will open the solenoid in MAN mode
	theNewValues.solenoid = 1

def newValuesInit():
#a function to initialize the values of the newValues class, used for storing new values from the GUI
	class newValues:
		setpoint = float(TheValues.PIDSetpoint[0])
		gain = float(TheValues.PIDGain[0])
		reset = float(TheValues.PIDResetRate[0])
		rate = float(TheValues.PIDRate[0])
		mode = float(TheValues.MstrWSystemMode)
		control = float(TheValues.MstrWControlPumpSol)
		pump = float(TheValues.PumpRunCmd)
		solenoid = float(TheValues.SolOpenCmd)
	return newValues

def csvWrite(TheValues):
#a function to write the measurement and timestamp to a CSV file   	
	with open("measurement.csv", "a") as myfile:	
		myfile.write(str(datetime.datetime.now()))
		myfile.write(',')
		myfile.write(str(TheValues.PIDPressureScaled[0]))
		myfile.write(',')
		myfile.write(str(TheValues.PIDSetpoint[0]))
		myfile.write('\n')
	#with open('measurement.csv', 'w') as csvfile:
    		#csvwriter = csv.writer(csvfile)
    		#csvwriter.writerows([datetime.datetime.now()] + [theNewValues.setpoint])

def getNewValues():
#a function for gettingsthe new values from the HMI. Checks to make sure the box isn't empty
	temp = TheGuiObjects.setpointEntry.get()
	if not temp:
		theNewValues.setpoint = float(TheValues.PIDSetpoint[0])
	else:
		theNewValues.setpoint = float(temp)
	
	temp = TheGuiObjects.gainEntry.get()
	if not temp:
		theNewValues.gain = float(TheValues.PIDGain[0])
	else:
		theNewValues.gain = float(temp)	

	temp = TheGuiObjects.resetEntry.get()
	if not temp:
		theNewValues.reset = float(TheValues.PIDResetRate[0])
	else:
		theNewValues.reset = float(temp)

	temp = TheGuiObjects.rateEntry.get()
	if not temp:
		theNewValues.rate = float(TheValues.PIDRate[0])
	else:
		theNewValues.rate = float(temp)	

def infiniteLoop():
#since the GUI mainloop takes up all the processor time, the redraw and communicate functions go here. The GUI mainloop will call this function.
	TheValues = modbusRead(modbusMaster)
	redrawGui(TheValues)
	getNewValues()
	time.sleep(0.5)
	csvWrite(TheValues)
	modbusWrite(modbusMaster,theNewValues)	
	TheGuiObjects.w.after(200,infiniteLoop)

if __name__ == "__main__":
	global modbusMaster
    	try:
       	 #Connect to the slave
		modbusMaster = modbus_tcp.TcpMaster()
	except modbus_tk.modbus.ModbusError, e:
        	print "Modbus error ", e.get_exception_code()
 	except Exception, e2:
        	print "Error ", str(e2)
	
	#initializations. These are global because the gui function that calls functions within mainloop doesn't accept arguements
	global TheValues, TheGuiObjects,theNewValues,theOldValues
	TheValues = modbusRead(modbusMaster)
	TheGuiObjects = guiInit(TheValues)
	theNewValues = newValuesInit()
	theOldValues = newValuesInit()
	f = open('measurement.csv', 'w')
	f.close()
	#since the main GUI loop takes up ALL the processor time, this schedules an event for 2000 miliseconds from now
	TheGuiObjects.w.after(2000,infiniteLoop)
	
	#start the main GUI loop 
	mainloop()
	
		
        	
        
    

   

