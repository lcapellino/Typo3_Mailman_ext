<?php

namespace Htwg\Mailmanext\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Htwg\Mailmanext\Domain\Model\Mailinglists;
use Htwg\Mailmanext\Domain\Model\Subscribe;
use Htwg\Mailmanext\Domain\Model\Unsubscribe;
use Htwg\Mailmanext\Domain\Model\MailmanPluginConfig;
use TYPO3\CMS\Core\Http\RequestFactory;


class ListController extends ActionController{

	/*
	This function shows all Mailinglists by 
	showing the view of Mailingslists from
	/Resources/Private/Templates/MailingList.html
	*/
	public $usermail = "";
	private $mailmanConfig;


	public function __construct(){
		$this->mailmanConfig = new MailmanPluginConfig();
	}

	public function listAction(){
		$usermail = "";
		if(isset($this->settings['usermail'])){
			$usermail = $this->settings['usermail'];
		}else if(isset($GLOBALS['TSFE']->fe_user->user['email'])){
			$usermail =$GLOBALS['TSFE']->fe_user->user['email'];
		} 

		$list = new Mailinglists($usermail, $this->settings, $this->mailmanConfig);
		$this->view->assign('list', $list);
		$this->view->assign('debug', $this);
	}
















	public function subscribeAction(){
		$usermail = "";
		if(isset($this->settings['usermail'])){
			$usermail = $this->settings['usermail'];
		}else if(isset($GLOBALS['TSFE']->fe_user->user['email'])){
			$usermail =$GLOBALS['TSFE']->fe_user->user['email'];
		} 

		//get the list_id from the GET-request
		$fqdn_list = $this->request->getArgument('list_id');

		//subscribe user to list
		$sub = new Subscribe($usermail, $fqdn_list, $this->mailmanConfig);

		//redirect to defined url
		$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mailmanext']);
		$redirectAddr = $extensionConfiguration['redirectAddr'];

		$this->redirectToUri($redirectAddr);
	}













	public function unsubscribeAction(){
		$usermail = "";
		if(isset($this->settings['usermail'])){
			$usermail = $this->settings['usermail'];
		}else if(isset($GLOBALS['TSFE']->fe_user->user['email'])){
			$usermail =$GLOBALS['TSFE']->fe_user->user['email'];
		} 
		$fqdn_list = $this->request->getArgument('list_id');
		$sub = new Unsubscribe($usermail, $fqdn_list, $this->mailmanConfig);

		$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mailmanext']);
		$redirectAddr = $extensionConfiguration['redirectAddr'];
		$this->redirectToUri($redirectAddr);
	}

	/**
	 * Itemsproc function to extend the selection of order fields in the plugin
	 *
	 * @param array &$config configuration array
	 */
	public function availableMailingLists(array &$config)    {
		
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
		$allMailinglists = json_decode($jsonAllMailinglists);

		foreach($allMailinglists->entries as $list){
			$config['items'][] = [$list->list_id, $list->list_id];
		}
	}

}
