#!/usr/bin/python3
from mailmanclient import Client
import sys


if len(sys.argv) != 2:
    exit()


client  = Client('http://localhost:8001/3.1/','restadmin','restpass')

listname = sys.argv[1]

list = client.get_list(listname)

print(list.rest_data['member_count'])

