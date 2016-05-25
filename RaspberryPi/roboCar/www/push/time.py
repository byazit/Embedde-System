import time
from time import gmtime, strftime
strftime("%Y-%m-%d %H:%M:%S", gmtime())
while True:
   try:
      f = open('example.txt','w')
      f.write(strftime("%Y-%m-%d %H:%M:%S", gmtime()))
      f.close()
      print strftime("%Y-%m-%d %H:%M:%S", gmtime())
      time.sleep(1)
   except KeyboardInterrupt:
      print "Program ended by user.\n"
      break 
print 'Success!'
