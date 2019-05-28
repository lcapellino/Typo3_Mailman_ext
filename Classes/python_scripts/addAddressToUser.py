#!/usr/bin/python3
from mailmanclient import Client
import cgi


import sys

if len(sys.argv) != 3:
    exit()

client  = Client('http://localhost:8001/3.1/','restadmin','restpass')

usermail = sys.argv[1]
additionalMail = sys.argv[2]


user = client.get_user(usermail)


user.add_address(additionalMail)


s = ""
for  address in user.addresses:
	print(str(address) + "<br>")





