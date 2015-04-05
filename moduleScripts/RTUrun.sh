#!/bin/bash

#script to start the tank simulation

term=gnome-terminal
#system=rtupipe
#system=rtuwater
#system=tcpwater
#system=tcptank
system2=tcppipe

logfile=$1

sudo true #Get the user to provide sudo power (necessary to open port 502)
cd ..
#Create ports
#symlinks="ttyS1 ttyS2 ttyS3"
#sudo gnome-terminal -x /bin/bash -c "protolibs/portlogger.py -r -n 0 -b 9600 -e --force_symlinks $symlinks -l $logfile -p /dev/ttyS1 -p /dev/ttyS2; exec bash"
sleep .2

#Start simulator & vdev1
#sudo $term -x /bin/bash -c "python simulator.py -s $system; exec bash" &
#sleep 1
#sudo $term -x /bin/bash -c "python vdev.py -s $system -d slave; exec bash"
#sleep 5

#Start simulator & vdev2
sudo $term -x /bin/bash -c "python simulator.py -s $system2; exec bash" &
sleep 1
sudo $term -x /bin/bash -c "python vdev.py -s $system2 -d slave; exec bash" 

#Start MASTER?
#sudo gnome-terminal -x /bin/bash -c "python vdev.py -s $system -d master; exec bash" & 

#Start attack scripts (optional)
#sleep 2
#sudo gnome-terminal -x /bin/bash -c "attacks/radio/rtu_dos_inject -inport /dev/pts/2; exec bash"
#sudo gnome-terminal -x /bin/bash -c "watch wc -l $logfile"
