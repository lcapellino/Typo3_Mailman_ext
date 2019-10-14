<?php

namespace Htwg\Mailmanext\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Htwg\Mailmanext\Domain\Model\Mailinglists;
use Htwg\Mailmanext\Domain\Model\Subscribe;
use Htwg\Mailmanext\Domain\Model\Unsubscribe;
use Htwg\Mailmanext\Domain\Model\MailmanPluginConfig;

use Htwg\Mailmanext\Classes\Services\MailmanService;
use TYPO3\CMS\Core\Http\RequestFactory;


class ListController extends ActionController{

	
	private $usermail = "";
	private $mailmanConfig;


	public function __construct(){
		$this->mailmanConfig = new MailmanPluginConfig();
	}

	public function listAction(){
		
		$this->setUserMail();
		$mailmanService = new MailmanService($this->usermail, $this->settings, $this->mailmanConfig);
		$list = $mailmanService->getMailinglists();
		$this->view->assign('list', $list);
		$this->view->assign('debug', $this);
	}

	public function subscribeAction(){
		
		$this->setUserMail();
		$mailmanService = new MailmanService($this->usermail, $this->settings, $this->mailmanConfig);
		//get the list_id from the GET-request
		$fqdn_list = $this->request->getArgument('list_id');

		//subscribe user to list
		$mailmanService->subscribe($fqdn_list);

		//redirect to defined url
		$this->redirectToUri($this->mailmanConfig->redirectaddr);
	}

	public function unsubscribeAction(){
		$this->setUserMail();
		$mailmanService = new MailmanService($this->usermail, $this->settings, $this->mailmanConfig);

		//get the list_id from the GET-request
		$fqdn_list = $this->request->getArgument('list_id');

		//unsub user from list
		$mailmanService->unsubscribe($fqdn_list);
		
		//redirect to defined url
		$this->redirectToUri($this->mailmanConfig->redirectaddr);
	}

	//If you're not using the TSFE usermail you should override this function
	public function setUserMail(){

		if(isset($this->settings['usermail'])){
			$this->usermail = $this->settings['usermail'];
		}else if(isset($GLOBALS['TSFE']->fe_user->user['email'])){
			$this->usermail =$GLOBALS['TSFE']->fe_user->user['email'];
		} 
	}

	/**
	 * Itemsproc function to extend the selection of mailingslists in the plugin
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
