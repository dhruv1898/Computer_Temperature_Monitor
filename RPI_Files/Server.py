###############################################################

# This python script run a TCP socket server and receives data
# from the computers connected on the same server. 

# The received data is saved and monitored. If the temperature 
# of the computer is above the critical temperature, an alert 
# email is sent.

###############################################################

import socket
import os
import smtplib, ssl
import csv


#Function to send email 
def criticalemail(robot,temperature):
    port = 587  # For starttls

    #change the server here
    smtp_server = "smtp.gmail.com"

    #change the sender email address here
    sender_email = "sender email address"

    #Type your password here or you can add manual input of password
    password = "add password of the sender email address"

    #Curate a personalised message here
    message = "The robot {robot} has crossed the critical temperature. Current Temperature is {temperature} deg C."
    
    context = ssl.create_default_context()
    with smtplib.SMTP(smtp_server, port) as server:
        server.ehlo()  # Can be omitted
        server.starttls(context=context)
        server.ehlo()  # Can be omitted
        server.login(sender_email, password)
        with open("emaildata.csv") as file:
            reader = csv.reader(file)
            for email in reader:
                server.sendmail(sender_email, email, message.format(robot=robot,temperature=temperature))
    return


#function to monitor the critical temperature
def criticaltemp(robotdata):
    
    splitdata = robotdata.split(',')
    for i in range(0,len(splitdata)):
        if "amd" in splitdata[i]:
            raw = splitdata[i]
        elif "core" in splitdata[i]:
            raw = splitdata[i]
                    
    datasplit = raw.split(':')
    newdatasplit = datasplit[1].replace("[ ","")
    newdatasplit = newdatasplit.replace("]","")
    newdatasplit = newdatasplit.split(" ")
            
    comptemp=[]
    for i in range(0,len(newdatasplit)):
        if u'\N{DEGREE SIGN}'+'C' in newdatasplit[i]:
            tempval = newdatasplit[i].replace(u'\N{DEGREE SIGN}'+'C','')
            comptemp.append(float(tempval))
                    
        elif '?' in newdatasplit[i]:
            tempval = newdatasplit[i].replace('?','')
            comptemp.append(float(tempval))
                    
    count = 0
    temperature = 0
    for i in range(0,len(comptemp)):
        if comptemp[i] >= 80:
            count +=1
        if comptemp[i] >= temperature:
            temperature = comptemp[i]
    if count > 0:
        criticalemail(robot,str(temperature))
    return
           

if __name__=="__main__":

    #Change HOST IP and PORT number here
    HOST = '192.168.102.137'
    PORT = 50007

    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.bind((HOST, PORT))

    #number of unaccepted connections before the server refuses more connections
    s.listen(10)

    while True:
        conn, addr = s.accept()
        print('Connected by', addr)
        data = conn.recv(4096).decode()
        robotname = data.split('=')
        datafile = robotname[0]+'.txt'

        #change the directory of storage here
        filedir = '/home/pi/Desktop/Server/Updatingdata'

        filepath = os.path.join(filedir,datafile)
        updata = robotname[0]+'('+str(addr[0])+')='+robotname[1]
        a = open(filepath,'w')
        a.write(updata)
        a.close()
        storedata = robotname[0]+'.txt'
        #change the directory of storage here
        filedir = '/home/pi/Desktop/Server/Loggeddata'

        filepath = os.path.join(filedir,storedata)
        b = open(filepath,'a')
        b.write("\n")
        b.write(data)
        b.close()
        conn.sendall(b'Data received')
        conn.close()
        robot = robotname[0]
       
        if ("amd" in robotname[1]) or ("core" in robotname[1]):
            robotdata =robotname[1]
            criticaltemp(robotdata)
            
    s.close()
