<?php
namespace Htwg\Mailmanext\Classes\Services;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\RequestFactory;
use Htwg\Mailmanext\Domain\Model\MailmanConfig;

class MailmanService extends AbstractEntity{     


	private $mailmanHost;
	private $mailmanUser;
	private $mailmanPassword;



	public function __construct(){
		$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mailmanext']);
		$this->mailmanHost = $extensionConfiguration['mailman.']['mailmanhost'];
		$this->mailmanUser = $extensionConfiguration['mailman.']['mailmanuser'];
		$this->mailmanPassword = $extensionConfiguration['mailman.']['mailmanpassword'];
	}

	/**
	 * This function returns a single mailinglist
	 *
	 * @param string $listID is the list to return
	 */
	public function getSingleMailinglist ($listID) {
		$listURL = $this->buildURL('lists/'.$listID);
		$mailinglist = $this->request($listURL, 'GET', null);

		return $mailinglist;
	}

	/**
	 * This function returns all mailinglists from the Mailman API
	 *
	 */
	public function getAllMailinglists () {
		//get all maillinglists from Mailman
		$listURL = $this->buildURL('lists');
		$allMailinglists = $this->request($listURL, 'GET', null);
		return $allMailinglists;
	}

	

	/**
	 * This function returns all mailinglists where the email is subscribed to
	 *
	 * @param string $email the email to search after
	 */

	public function getUserSubscriptions($email){
		$subscribedListsURL = $this->buildURL('members/find?subscriber='. $email);
		$userSubscribedMailinglists = $this->request($subscribedListsURL, 'GET', null);
		return $userSubscribedMailinglists;

	}

	/**
	 * This function subcribes an email to a mailinglist
	 *
	 * @param string $ListIdToSubscribe the id of the list 
	 * @param string $email the email to subscribe
	 */
	public function subscribe($ListIdToSubscribe, $email){
		$url = $this->buildURL('members');
		$formParams = ['subscriber' => $email,
				'list_id' => $ListIdToSubscribe,
				'display_name' => null,
				'pre_confirmed' => true,
				'pre_verified' => true,
			];
		$this->request($url, 'POST', $formParams);
	}

	/**
	 * This function unsubscribes the given email from the list
	 *
	 * @param string $ListIdToUnsubscribe is the id of the list
	 * @param string $email the email to unsubscribe
	 */

	public function unsubscribe($ListIdToUnsubscribe, $email){
		$url = $this->buildURL('lists/'.$ListIdToUnsubscribe.'/member/'.$email);
		$this->request($url, 'DELETE', null);
	}

	/**
	 * make a request to the Mailman REST-API and returns the deocded JSON
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
		'auth' => [$this->mailmanUser,$this->mailmanPassword],
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
		return $this->mailmanHost. $path;
	}
	
}
