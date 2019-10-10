<?php
namespace Htwg\Mailmanext\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\RequestFactory;
use Htwg\Mailmanext\Domain\Model\MailmanConfig;

class Mailinglists extends AbstractEntity{     

	public $allMailinglists='';
	public $userMailinglists='';
	private $mail;
	private $mailmanconfig;
	private $debug;
	private $availableLists;
	private $settings;

	public function userIsSubscribed(){

		
		$this->availableLists =  explode(',', $this->settings['selectmailinglists']);

		foreach($this->allMailinglists->entries as $globalList){
			foreach ($this->availableLists as $key => $listID) {
				if($globalList->list_id == $listID){
					$globalList->selected = true;
					break;
				}else{
					$globalList->selected = false;
				}
			}
			if(is_array($this->userMailinglists->entries)){
				foreach($this->userMailinglists->entries as $userList){
					if($globalList->list_id == $userList->list_id && $userList->role == 'member'){
						$globalList->userInList = true;
						break;
					}else{
						$globalList->userInList = false;
					}	
				}
			}
			
		}
	}

	public function __construct($mail, $settings, $mailmanConfig){
		$this->settings = $settings;
		$this->mailmanConfig = $mailmanConfig;
		$this->mail = $mail;

		$requestFactory = GeneralUtility::makeInstance(RequestFactory::class);

		$url = $this->mailmanConfig->mailmanHost. 'lists';
		$additionalOptions = [
		'headers' => ['Cache-Control' => 'no-cache'],
		'allow_redirects' => false,
		'auth' => [$this->mailmanConfig->mailmanUser,$this->mailmanConfig->mailmanPassword],
		];
		
		$response = $requestFactory->request($url, 'GET', $additionalOptions);

		// Get the content as a string on a successful request
		if ($response->getStatusCode() === 200) {
			if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0) {
				$jsonAllMailinglists = $response->getBody()->getContents();
			}
		}
		$this->allMailinglists = json_decode($jsonAllMailinglists);

		$url = $this->mailmanConfig->mailmanHost. 'members/find?subscriber='. $mail;
		$additionalOptions = [
		'headers' => ['Cache-Control' => 'no-cache'],
		'allow_redirects' => false,
		'auth' => [$this->mailmanConfig->mailmanUser,$this->mailmanConfig->mailmanPassword],
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
