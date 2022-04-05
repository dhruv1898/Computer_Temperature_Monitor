import socket
import os
import smtplib, ssl

def criticalemail(robot,temperature):
    port = 587  # For starttls
    smtp_server = "smtp.gmail.com"
    sender_email = "sender email address"
    password = "Type your password and press enter:"
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
    HOST = '192.168.102.137'
    PORT = 50007#50007
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.bind((HOST, PORT))
    s.listen(10)

    while True:
        conn, addr = s.accept()
        print('Connected by', addr)
        data = conn.recv(4096).decode()
        robotname = data.split('=')
        datafile = robotname[0]+'.txt'
        filedir = '/home/pi/Desktop/Server/Updatingdata'
        filepath = os.path.join(filedir,datafile)
        a = open(filepath,'w')
        a.write(data)
        a.close()
        storedata = robotname[0]+'.txt'
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
