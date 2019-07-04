================
Template editing
================

Mailman Extension comes with a default HTML template. The Template is located under mailmanext/Resources/Private/Templates/MailingList.html (**do not change the name!**). Feel free to edit this so it fits your needs

.. highlight:: html
::
	<table border="1" cellspacing="1" cellpadding="5">
	  <tr>
	    <td>Listen name</td>
	    <td>Full Qualified Domain Name</td>
		  <td>Anzahl Nutzer</td>
		  <td>Einschreiben</td>
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



Inside the for loop you can select the following values from the mailinglists
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

These are all values from Mailman. To get more debug information uncomment the debug command 
::
	<f:comment>
		<f:debug>{list}</f:debug>
	</f:comment>
