<?php
namespace Htwg\Mailmanext\Classes\Services;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\RequestFactory;
use Htwg\Mailmanext\Domain\Model\MailmanConfig;

class MailmanService extends AbstractEntity{     


	private $mail;
	private $mailmanconfig;
	private $settings;



	public function __construct($mail, $settings, $mailmanConfig){
		$this->settings = $settings;
		$this->mailmanConfig = $mailmanConfig;
		$this->mail = $mail;
	}

	public function getMailinglists(){
		//get all maillinglists from Mailman
		$listURL = $this->buildURL('lists');
		$allMailinglists = $this->request($listURL, 'GET', null);

		//get all mailinglists to wich the user is subscribed
		$subscribedListsURL = $this->buildURL('members/find?subscriber='. $this->mail);
		$userSubscribedMailinglists = $this->request($subscribedListsURL, 'GET', null);

		//add the SELECTED and USERINLIST attribute
		$allMailinglistsWithAttributes = $this->getListWithSelectedAndUserInListAttr($allMailinglists, $userSubscribedMailinglists);
		return $allMailinglistsWithAttributes;
	}

	
	private function getListWithSelectedAndUserInListAttr($allMailinglists, $userSubscribedMailinglists){
		//get the selected mailinglists from the plugin 
		$availableLists =  explode(',', $this->settings['selectmailinglists']);

		foreach($allMailinglists->entries as $allMailinglistsEntry){
			foreach ($availableLists as $key => $listID) {
				//checks if the list is selected 
				if($allMailinglistsEntry->list_id == $listID){
					$allMailinglistsEntry->selected = true;
					break;
				}else{
					$allMailinglistsEntry->selected = false;
				}
			}
			if(is_array($userSubscribedMailinglists->entries)){
				foreach($userSubscribedMailinglists->entries as $userList){
					//checks if the user is subscribed to the list
					if($allMailinglistsEntry->list_id == $userList->list_id && $userList->role == 'member'){
						$allMailinglistsEntry->userInList = true;
						break;
					}else{
						$allMailinglistsEntry->userInList = false;
					}	
				}
			}
		}
		return $allMailinglists;
	}


	public function subscribe($ListIdToSubscribe){
		$url = $this->buildURL('members');
		$formParams = ['subscriber' => $this->mail,
				'list_id' => $ListIdToSubscribe,
				'display_name' => null,
				'pre_confirmed' => true,
				'pre_verified' => true,
			];
		$this->request($url, 'POST', $formParams);
	}

	/**
	 * This function unsubscribes the given mail from the list
	 *
	 * @param string $ListIdToUnsubscribe is the id from the mailinglist to unsubscribe from
	 */

	public function unsubscribe($ListIdToUnsubscribe){
		$url = $this->buildURL('lists/'.$ListIdToUnsubscribe.'/member/'.$this->mail);
		$this->request($url, 'DELETE', null);
	}

	/**
	 * make a request to the Mailman REST-API
	 *
	 * @param string $url is the url to the REST-API
	 * @param string $method is the http method
	 * @param array $formParam parameters that are added to the request
	 */

	private function request($url, $method, $formParams){
		$requestFactory = GeneralUtility::makeInstance(RequestFactory::class);
		$additionalOptions = [
		'headers' => ['Cache-Control' => 'no-cache'],
		'allow_redirects' => false,
		'auth' => [$this->mailmanConfig->mailmanUser,$this->mailmanConfig->mailmanPassword],
		];
			

		if(!is_null($formParams)){
			$additionalOptions['form_params'] = $formParams;
		}

		$response = $requestFactory->request($url, $method, $additionalOptions);

		// Get the content as a string on a successful request
		if ($response->getStatusCode() === 200) {
			if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0) {
				$jsonAllMailinglists = $response->getBody()->getContents();
			}
		}

		return json_decode($jsonAllMailinglists);
	}

	/**
	 * builds a url from the configured Mailman REST-API and the given ressource
	 *
	 * @param string $ath the path to the rest ressource
	 */

	private function buildURL($path){
		return $this->mailmanConfig->mailmanHost. $path;
	}
	
}
