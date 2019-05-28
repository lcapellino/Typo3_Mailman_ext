#!/usr/bin/python3
from mailmanclient import Client
import sys

if len(sys.argv) != 4:
    exit()

client  = Client('http://localhost:8001/3.1/','restadmin','restpass')

listname = sys.argv[1]
mail = sys.argv[2]
name = sys.argv[3]

list = client.get_list(listname)

data = list.subscribe(mail,  pre_confirmed = True, pre_verified= True)

for member in list.members:
		print(str(member.address) + "<br>" )


