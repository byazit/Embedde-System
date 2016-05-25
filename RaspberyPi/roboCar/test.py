import numpy as np
l = [15, 18, 2, 36, 12, 78, 5, 6, 9]
print np.mean(l)
print l[0]
myList=[]
for i in range(5):
    myList.append(l[i])
for i in range(1):
   print myList[i]

print np.mean(myList)

my_list = []
plus_one = []
for x in range(5):
    userInput = int(input("Enter a number: "))
    my_list.append(userInput)
    plus_one.append(userInput+1) 

print my_list
print plus_one

def average():
    average = sum(my_list) / len(my_list) 
    return average

print average()
