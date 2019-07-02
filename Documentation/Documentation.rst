
Backend Configuration
------------------------

#. After the installation of this extension go to **ADMIN TOOLS** in your TYPO3 Backend. Next, click on **Extensions** and search **mailmanext**. You should see the Mailman Extension. 
#. Click on the Configure-Button to set the values. The values are preconfigured to the standard Mailman installation.
#. Set the **usermail** so the Plugin can un/subscribe the correct email. To do this, go to the Plugin folder of your TYPO3 installtation. Now navigate to mailmanext/Configuration/Typoscript/setup.typoscript and set the **usermail** variable with your frontenduser mail 
::
	plugin.tx_mailmanext.settings{
    	usermail = user@mail.de
	}

Plugin Configuration
------------------------

After you added the Plugin to a page you should select the mailinglist you want the user to see. To do this, go to the Page and edit the Plugin, now select the lists you want the user to see. Don't forget to save!
