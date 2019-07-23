================
Template editing
================

Mailman Extension comes with a default HTML template. The Template is located under mailmanext/Resources/Private/Templates/MailingList.html (**do not change the name!**). Feel free to edit this so it fits your needs.

.. highlight:: html

::

  <f:if condition="{list}">
    <f:then>
      <table border="1" cellspacing="1" cellpadding="5">
        <tr>
	        <td>Name</td>
	        <td>Full qualified domain name</td>
	        <td>Member count</td>
	        <td>Un/Subscribe</td>	
        </tr>
        <f:for each="{list.allMailinglists.entries}" as="mailinglist">
	        <f:if condition="{mailinglist.selected}">
		        <tr>
			        <td align="top">{mailinglist.display_name}</td>	
			        <td align="top">{mailinglist.fqdn_listname}</td>
			        <td align="top">{mailinglist.member_count}</td>
			        <td>
				        <f:comment>Only show Lists that are selected in the Plugin Option</f:comment>
				        <f:if condition="{mailinglist.userInList}">
					        <f:then>
						        <f:link.action action="unsubscribe" controller="MailmanExt" arguments="{list_id: '{mailinglist.list_id}'}">unsubscribe</f:link.action>
					        </f:then>
					        <f:else>
						        <f:link.action action="subscribe" controller="MailmanExt" arguments="{list_id: '{mailinglist.list_id}'}">subscribe</f:link.action>
					        </f:else>
				        </f:if>
			        </td>
		        </tr>
	        </f:if>
        </f:for>
      </table>
    </f:then>
    <f:else>
        you did not set an email in your Typoscript or you did not implement $GLOBALS['TSFE']. <br>
        To add a test email in Typoscript add following to your template: <br>
        plugin.tx_mailmanext.settings{<br>
      usermail = testuser@mail.com<br>
    }<br>
    </f:else>
  </f:if>



Inside the for loop you can select the following values from the mailinglists. These are all values from Mailman. 
::
	mailinglist.description

	mailinglist.display_name

	mailinglist.fqdn_listname

	mailinglist.http_etag

	mailinglist.list_id

	mailinglist.list_name

	mailinglist.mail_host

	mailinglist.member_count

	mailinglist.self_link

	mailinglist.volume

	mailinglist.selected


