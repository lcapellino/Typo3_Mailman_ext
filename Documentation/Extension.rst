=======================
Extension Configuration
=======================




After the installation of this extension go to **ADMIN TOOLS** in your TYPO3 Backend. Next, click on **Extensions** and search **mailmanext**. You should see the Mailman Extension.

Click on the Configure-Button to set the values. The values are preconfigured to the standard Mailman installation.
|extension_conf|

.. |extension_conf| image:: extension_conf.png
                :alt: alt="Extension Configuration"

Set the **usermail** so the Plugin can un/subscribe the correct email. To do this, go to the Plugin folder of your TYPO3 installtation. Now navigate to **mailmanext/Configuration/Typoscript/setup.typoscript** and set the **usermail** variable to the mail of the user in your frontend.
::
	plugin.tx_mailmanext.settings{
        usermail = user@mail.de
	}
