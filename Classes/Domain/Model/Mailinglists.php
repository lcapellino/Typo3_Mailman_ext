<?php
namespace Htwg\Mailmanext\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\RequestFactory;

class Mailinglists extends AbstractEntity{     

 	public $allMailinglists='';
 	public $userMailinglists='';
 	private $mail;
 	private $mailmanHost;
 	private $mailmanUser;
 	private $mailmanPassword;
 	private $debug;

	public function userIsSubscribed(){
		foreach($this->allMailinglists->entries as $globalList){
			foreach($this->userMailinglists->entries as $userList){
				if($globalList->list_id == $userList->list_id){
					$globalList->userInList = true;
					break;
				}else{
					$globalList->userInList = false;
				}	
			}
		}
	}

 	public function __construct($mail){
 		$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mailmanext']);
        $this->mailmanHost = $extensionConfiguration['mailman.']['mailmanhost'];
        $this->mailmanUser = $extensionConfiguration['mailman.']['mailmanuser'];
        $this->mailmanPassword = $extensionConfiguration['mailman.']['mailmanpassword'];
        $this->mail = $mail;

		$requestFactory = GeneralUtility::makeInstance(RequestFactory::class);

		$url = $this->mailmanHost. 'lists';
		$additionalOptions = [
	   'headers' => ['Cache-Control' => 'no-cache'],
	   'allow_redirects' => false,
	   'auth' => [$this->mailmanUser,$this->mailmanPassword],
		];
		
		$response = $requestFactory->request($url, 'GET', $additionalOptions);

		// Get the content as a string on a successful request
		if ($response->getStatusCode() === 200) {
	   		if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0) {
	      	$jsonAllMailinglists = $response->getBody()->getContents();
	   		}
		}
		$this->allMailinglists = json_decode($jsonAllMailinglists);

		$url = $this->mailmanHost. 'members/find?subscriber='. $mail;
		$additionalOptions = [
	   'headers' => ['Cache-Control' => 'no-cache'],
	   'allow_redirects' => false,
	   'auth' => [$this->mailmanUser,$this->mailmanPassword],
		];
		
		$response = $requestFactory->request($url, 'GET', $additionalOptions);

		$this->debug = $url;

		if ($response->getStatusCode() === 200) {
			if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0) {
	      	$jsonUserMailinglists = $response->getBody()->getContents();
	   		}
		}
		$this->userMailinglists = json_decode($jsonUserMailinglists);



		$this->userIsSubscribed();
	}

	
}
