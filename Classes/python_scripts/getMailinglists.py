#!/usr/bin/python3

import httplib2
import sys

#if len(sys.argv) != 4:
 #   exit()

#mailmanhost = sys.argv[1]
#mailmanuser = sys.argv[2]
#mailmanpasswort = sys.argv[3]



h = httplib2.Http(".cache")

h.add_credentials("restadmin", "restpass") # Basic authentication

resp, content = h.request("http://localhost:8001/3.1/lists", "GET", body="foobar")
print(content.decode('utf-8'))

#client  = Client('http://localhost:8001/3.1/','restadmin','restpass')

#lists = client.get_lists()
#print(str(json.dumps(lists)))
#for list in lists: 
	#print(str(list.rest_data['fqdn_listname']) + " ->" + str(list.rest_data['member_count']) + "<br>")
	#print(json.dumps(list))