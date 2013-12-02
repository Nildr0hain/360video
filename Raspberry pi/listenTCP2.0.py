import socket
import sys
from thread import *
from RPIO import PWM
import math

servo = PWM.Servo()
percentage = 50

def calculatePulse(percentage):
    
    return 700 + (1800*percentage/100)

def controlMotor(direction):
    global percentage

    if direction == 0:
        percentage-=1
    elif direction == 1:    
        percentage = 50
    elif direction == 2:
        percentage+=1

    if percentage <0:
        percentage = 0
    elif percentage >100:
        percentage = 100

    print(calculatePulse(percentage))
    pulse = int(round(calculatePulse(percentage)/10.0))*10
    servo.set_servo(18,pulse)
    print(pulse)
    return


servo.set_servo(18,calculatePulse(percentage))


HOST = '' # Symbolic name meaning all available interfaces
PORT = 8888 # Arbitrary non-privileged port

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
print 'Socket created'
#Bind socket to local host and port
try:
 s.bind((HOST, PORT))
except socket.error , msg:
 print 'Bind failed. Error Code : ' + str(msg[0]) + ' Message ' + msg[1]
 sys.exit()
 
print 'Socket bind complete'

#Start listening on socket
s.listen(10)
print 'Socket now listening'

#Function for handling connections. This will be used to create threads
def clientthread(conn):
 #Sending message to connected client
 conn.send('Welcome to the server. Type something and hit enter\n\r') #send only takes string
 
 #infinite loop so that function do not terminate and thread do not end.
 while True:
  
  #Receiving from client
  data = conn.recv(1024)
  data = data.rstrip('\r\n')
    
  if data == "L" or data == "l":
      reply = '\n\rje hebt L gestuurd\n\r'
      controlMotor(0)
  elif data == "R" or data == "r":
      reply = "\n\rje hebt R gestuurd\n\r"
      controlMotor(2)
  elif data == "M" or data == "m":
      reply = "\n\rje hebt M gestuurd\n\r"
      controlMotor(1)
  else :
      reply = '\n\rserver:' + data + ' is geen geldige invoer\n\r'
  
  
  if not data: 
   break
 
  conn.sendall(reply)
 
 #came out of loop
 conn.close()

#now keep talking with the client
while 1:
    #wait to accept a connection - blocking call
 conn, addr = s.accept()
 print 'Connected with ' + addr[0] + ':' + str(addr[1])
 
 #start new thread takes 1st argument as a function name to be run, second is the tuple of arguments to the function.
 start_new_thread(clientthread ,(conn,))

s.close()
