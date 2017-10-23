# -*- coding: utf-8 -*-
"""
Created on Fri Aug 11 01:04:05 2017

@author: Ahmad khan
"""

import socket
import sys
import cv2
import json

def imgtonum(name):
    im = cv2.imread(name)
    cv2.imwrite('test3.jpg', im )
    list1=[]
    #in this order
    #y-ax ,x-ax,hight,width,name
    list2=[100,100,20,40,"Hammad"]
    list3=[200,150,20,30,"Qasim"]
    list4=[240,180,20,40,"Jawad"]
    list1.append(list2)
    list1.append(list3)
    list1.append(list4)
    tup2=tuple(list1)
    return(json.dumps(tup2))

s=socket.socket(socket.AF_INET,socket.SOCK_STREAM)
host= '127.0.0.1'
port=int(3000)
s.bind((host,port))
s.listen(1)
#now keep talking with the client
while 1:
    #wait to accept a connection - blocking call
   conn, addr = s.accept()
   data=conn.recv(100000)
   data=data.decode("utf-8")
   recv=imgtonum(data)
   sendable=recv.encode("utf-8")
   conn.sendall(sendable)
s.close()

