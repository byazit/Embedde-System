
# Import required Python libraries
import time
import RPi.GPIO as GPIO
import numpy as np
import sys

# Use BCM GPIO references
# instead of physical pin numbers
GPIO.setmode(GPIO.BOARD)
# Define GPIO to use on Pi
GPIO_TRIGGER = 16
GPIO_ECHO = 18
GPIO_LED=12
GPIO_SERVO=11
print "Ultrasonic Measurement"

# Set pins as output and input
GPIO.setup(GPIO_TRIGGER,GPIO.OUT)  # Trigger
GPIO.setup(GPIO_ECHO,GPIO.IN)      # Echo
GPIO.setup(GPIO_LED, GPIO.OUT)     #led
GPIO.setup(GPIO_SERVO, GPIO.OUT)	 #servo
sonicPulse=GPIO.PWM(GPIO_SERVO,50)
sonicPulse.start(7.5)



# back motor control
BACK_A1=8
BACK_A2=10
GPIO.setup(BACK_A1, GPIO.OUT)
GPIO.setup(BACK_A2, GPIO.OUT)
speed=100
clock=20
p=GPIO.PWM(BACK_A1,clock)
q=GPIO.PWM(BACK_A2,clock)

p.start(0)
q.start(0)


#front motor
FRONT_B1=13
FRONT_B2=15
GPIO.setup(FRONT_B1, GPIO.OUT)
GPIO.setup(FRONT_B2, GPIO.OUT)

def pnt():

  print "razib"

#moto forward
def mForward():
  q.ChangeDutyCycle(0)
  while True:
    pnt()
    for i in range(speed):
		  p.ChangeDutyCycle(i)
    

#moto back
def mBack():
  print "back"
  p.ChangeDutyCycle(0)
  for i in range(100):
    q.ChangeDutyCycle(i)

#motor right
def mRight():
  GPIO.output(FRONT_B1,1)
  GPIO.output(FRONT_B2,0)
#motor left
def mLeft():
  GPIO.output(FRONT_B1,0)
  GPIO.output(FRONT_B2,1)
#motor straight
def straight():
  GPIO.output(FRONT_B1,0)
  GPIO.output(FRONT_B2,0)
def stop():
    sys.exit()
    GPIO.cleanup()
  #GPIO.output(BACK_A1,0)
  #GPIO.output(BACK_A2,0)

#Rules for when to stop and make dicition
def rules(distance):
  if distance<30:
    print "Object detected : %.1f" % distance
    stop()
  else:
    mForward()


def sonic():
  GPIO.output(GPIO_TRIGGER, False)
  # Allow module to settle
  time.sleep(0.5)
  GPIO.output(GPIO_TRIGGER, True)
  time.sleep(0.00001)
  GPIO.output(GPIO_TRIGGER, False)
  start = time.time()
  while GPIO.input(GPIO_ECHO)==0:
    start = time.time()
    #print "Echo start"
  while GPIO.input(GPIO_ECHO)==1:
    stop = time.time()
    #print "echo stop"
  # Calculate pulse length
  elapsed = stop-start
  # Distance pulse travelled in that time is time
  # multiplied by the speed of sound (cm/s)
  distance = elapsed * 34000
  distance = distance / 2
  print "-------------> " 
  rules(distance)
  #myList.append(distance)

for i in range(0,1):
  mForward()
  sonic()
  time.sleep(1)
stop()
GPIO.cleanup()



