#######################################################################################

# This python script runs on lm-sensors library and uses sensors.py to fetch data
# from the onboard sensors of a computer
# References: 
# https://github.com/lm-sensors/lm-sensors
# https://github.com/paroj/sensors.py

#######################################################################################

import time
import sensors
import numpy as np
from time import sleep
from datetime import datetime
import socket
import smtplib
np.set_printoptions(suppress=True)

#get name of the computer/device
device_name = socket.gethostname()


#assigning units to the data
def dataunit(data):
    if "temp" in label:
        unit = u'\N{DEGREE SIGN}'+'C'
        #print(unit)
    elif "vdd" in label:
        unit = 'V'
    elif "edge" in label:
        unit = u'\N{DEGREE SIGN}'+'C'
    elif "PHY Temperature" in label:
        unit = u'\N{DEGREE SIGN}'+'C'
    elif "MAC Temperature" in label:
        unit = u'\N{DEGREE SIGN}'+'C'
    elif "Sensor" in label:
        unit = u'\N{DEGREE SIGN}'+'C'
    elif "Composite" in label:
        unit = u'\N{DEGREE SIGN}'+'C'
    elif "Tccd" in label:
        unit = u'\N{DEGREE SIGN}'+'C'
    elif "Tdie" in label:
        unit = u'\N{DEGREE SIGN}'+'C'
    elif "Tctl" in label:
        unit = u'\N{DEGREE SIGN}'+'C'
    elif "power" in label:
        unit = 'W'
    elif "Core" in label:
        unit = u'\N{DEGREE SIGN}'+'C'
    elif "in" in label:
        unit = 'V'
    elif "curr" in label:
        unit = 'A'
    elif "fan" in label:
        unit = 'rpm'
    else:
        unit = '?' #change it to another unit
    return unit


if __name__ == "__main__":

    print(device_name)
    while True:

        #using lm-sensors library to get the data
        data_string = device_name+'='
        sensors.init()
        for chip in sensors.ChipIterator():
            
            
            #you can change the length of the array if the computers have less or more data values for a specific processor or adapter
            device_data = np.zeros(7)


            chip_name = sensors.chip_snprintf_name(chip)
            i = 0
            data_string = data_string+','+chip_name+':['
            for feature in sensors.FeatureIterator(chip):
                unit =""
                sfi = sensors.SubFeatureIterator(chip, feature)
                try:
                    vals = [sensors.get_value(chip, sf.number) for sf in sfi]
                    label = sensors.get_label(chip, feature)
                    #print(label)
                    
                    device_data[i]=vals[0]
                    #print(unit)
                    unit = dataunit(label)
                except:
                    vals[0]=0
                    pass
                i+=1
                data_string = data_string+' '+str(vals[0])+unit
            data_string = data_string+']'
        
        #change the HOST IP and PORT number
        HOST = '192.168.102.137'
        PORT = 50007


        s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        s.connect((HOST, PORT))
        print(data_string)
        s.send(data_string.encode('utf-8'))
        data = s.recv(4096)
        print(data)
        s.close()
        sleep(60)
        sensors.cleanup()
