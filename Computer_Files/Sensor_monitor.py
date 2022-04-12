import time
import sensors
import numpy as np
from time import sleep
from datetime import datetime
import socket
import smtplib
np.set_printoptions(suppress=True)
device_name = socket.gethostname()


#Assign units to the data from the sensors
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
        unit = '?'
    return unit


if __name__ == "__main__":

    print(device_name)
    while True:
        data_string = device_name+'='
        sensors.init()
        for chip in sensors.ChipIterator():
            device_data = np.zeros(7)
            #print(sensors.chip_snprintf_name(chip)+" ("+sensors.get_adapter_name(chip.bus)+")")
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
        
        #Send data to the server using a TCP socket
        HOST = '192.168.102.137' #change IP address to the RPI's IP address
        PORT = 50007 #port number can be changed (optional)
        s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        s.connect((HOST, PORT))
        print(data_string)
        s.send(data_string.encode('utf-8'))
        data = s.recv(4096)
        print(data)
        s.close()
        sleep(60)
        sensors.cleanup()
