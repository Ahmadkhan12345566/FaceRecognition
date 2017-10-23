# -*- coding: utf-8 -*-
"""
Created on Tue Aug  1 02:41:15 2017

@author: Ahmad khan
"""
import cv2
from matplotlib import image
import sys
#name="git.jpg"
name = sys.argv[1]
im = cv2.imread(name)
cv2.imwrite('test3.jpg', im )
#print("abc")
list1=[]
list2=[90,70,20,40,"khan"]
list1.append(list2)
list1.append(list2)
list1.append(list2)
list1.append(list2)
list1[1]=list2
tup2=tuple(list1)
print(json.dumps(tup2))
