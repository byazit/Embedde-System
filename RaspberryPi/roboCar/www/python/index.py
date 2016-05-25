#!/usr/bin/python
import MySQLdb
import RPi.GPIO as GPIO
import time
GPIO.setmode(GPIO.BOARD)



def dbConn():
        db = MySQLdb.connect("localhost",user="root",passwd="#razib3417#",db="gpioPin") 
        cur = db.cursor(MySQLdb.cursors.DictCursor)
        cur.execute("SELECT * FROM pinMap")
        return cur
# you must create a Cursor object. It will let
#  you execute all the queries you need

# Use all the SQL you like

# print all the first cell of all the rows

try:
   while True:
        cur=dbConn()
        print "|ID  |GPOI num\t|Status\t|"
        print "+-----------------------+"
        for row in cur.fetchall() :
            print "|",row['id'], "|" ,row["pin"], "\t|" , row['status'], "\t|"
            GPIO.setup(int(row["pin"]), GPIO.OUT)
            GPIO.output(int(row["pin"]),int(row["status"]))
        print "+-----------------------+"
        time.sleep(2)
except KeyboardInterrupt:
				pass
GPIO.cleanup()
