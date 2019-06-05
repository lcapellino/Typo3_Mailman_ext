Typo3 Mailman Extension
==============================================================
This Typo3 Extension provides basic functionalities to subscribe or unsubscribe an email to a mailinglist. 

This Extension is already pre-configured with the basic Mailman authentication. To change these just edit the **ext_conf_template.txt** file or in the Typo3 backend after the installation in the __Extension__ section.

To set the correct Front-End-User email you have to override **/Configuration/Typoscript/setup.typoscript** and set the usermail.

```
plugin.tx_mailmanext.settings{
    usermail = user@mailde
}
```
