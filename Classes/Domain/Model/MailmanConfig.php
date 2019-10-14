<?php
namespace Htwg\Mailmanext\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\RequestFactory;

class MailmanPluginConfig extends AbstractEntity
{
	public $mailmanHost;
	public $mailmanUser;
	public $mailmanPassword;
	public $redirectaddr;


	public function __construct(){
		$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mailmanext']);
		$this->mailmanHost = $extensionConfiguration['mailman.']['mailmanhost'];
		$this->mailmanUser = $extensionConfiguration['mailman.']['mailmanuser'];
		$this->mailmanPassword = $extensionConfiguration['mailman.']['mailmanpassword'];
		$this->redirectaddr = $extensionConfiguration['redirectAddr'];
	}
}
