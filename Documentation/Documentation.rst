
Backend Configuration
------------------------

#. After the installation of this extension go to **ADMIN TOOLS** in your TYPO3 Backend. Next, click on **Extensions** and search **mailmanext**. You should see the Mailman Extension

#. Click on the Configure-Button to set the values. The values are preconfigured to the standard Mailman installation

#. Set the **usermail** so the Plugin can un/subscribe the correct email. To do this, go to the Plugin folder of your TYPO3 installtation. Now navigate to mailmanext/Configuration/Typoscript/setup.typoscript and set the **usermail** variable with your frontenduser mail 
::
	plugin.tx_mailmanext.settings{
    	usermail = user@mail.de
	}

Plugin Configuration
------------------------

After you added the Plugin to a page you should select the mailinglist you want the user to see. To do this, go to the Page and edit the Plugin, now select the lists you want the user to see. Don't forget to save!

Template editing
------------------------

#. Mailman Extension comes with a default HTML template. The Template is located under mailmanext/Resources/Private/Templates/MailingList.html (**do not change the name!**). Feel free to edit this so it fits your needs
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

#. Inside the for loop you can select the following values from the mailinglists
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
