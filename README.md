# Computer_Temperature_Monitor
This repo uses the [lm-sensors](https://github.com/lm-sensors/lm-sensors) to monitor the temperature of the onboard processor and other sensor data of the adapters.
You need to clone the directory **Computer_Files** into the computer to be monitored and the directory **RPI_Files** into the raspberry pi to be used as a server.
After cloning the directories following changes should be applied for the scripts to work:
- For Computer_Files
   - In Sernsors_monitor.py
     - Change the array length based on the maximum data values received on a computer.
      ```
      device_data = np.zeros(7)
      ```
     - Change the HOST IP and PORT number
      ```
      HOST = '192.168.102.137'
      PORT = 50007
      ``` 
- For RPI_Files
  - In Server.py
    - Change the server, add sender email address, add passowrd or use manual input.
      ```
      #change the server here
      smtp_server = "smtp.gmail.com"

      #change the sender email address here
      sender_email = "sender email address"

      #Type your password here or you can add manual input of password
      password = "add password of the sender email address"   
      ``` 
    - Add a personalized message here.
      ```
      #Curate a personalised message here
      message = "The robot {robot} has crossed the critical temperature. Current Temperature is {temperature} deg C."
      ```
    - Change the HOST IP and PORT number
      ```
      HOST = '192.168.102.137'
      PORT = 50007
      ``` 
    - Change the directory to store updating data
      ```
      #change the directory of storage here
      filedir = '/home/pi/Desktop/Server/Updatingdata'
      ```
    - Change the directory to store logged data
      ```
      #change the directory of storage here
      filedir = '/home/pi/Desktop/Server/Loggeddata'
      ```
  - For index.php
    - Change the directory here:
      ```
      $dir = '/home/pi/Desktop/Server/Updatingdata/';
      ```
      here
      ```
      $logdir='/home/pi/Desktop/Server/Loggeddata/';
      ```
      
    - Change the file location for the email list here:
      ```
      $fpdata = file_get_contents('emaildata.csv'); //change file location here
      ```
      and here
      ```
      $ftpdata = file_get_contents('emaildata.csv'); //change file location here
      ```
