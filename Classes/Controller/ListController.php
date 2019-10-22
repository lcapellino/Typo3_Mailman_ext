<?php

namespace Htwg\Mailmanext\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Htwg\Mailmanext\Domain\Model\MailmanPluginConfig;

use Htwg\Mailmanext\Classes\Services\MailmanService;
use TYPO3\CMS\Core\Http\RequestFactory;


class ListController extends ActionController{

	
	private $usermail = "";
	private $mailmanService;
	private $redirectaddr;

	/**
     * initializeAction
     */
	public function initializeAction() {
		$this->setUserMail();
		$this->mailmanService = new MailmanService();
		$this->redirectaddr = $extensionConfiguration['redirectAddr'];
	}


	/**
	* This function is called when the multiplelist Plugin is selected.
	* 
	*/
	
	public function multipleListAction(){
		
		$selectedMailinglists = explode(',', $this->settings['selectmailinglists']);

		$allMailinglists = $this->mailmanService->getAllMailinglists();

		//get all mailinglists to wich the user is subscribed
		$userSubscribedMailinglists = $this->mailmanService->getUserSubscriptions($this->usermail);

		//add the SELECTED and USERINLIST attribute
		foreach($allMailinglists->entries as $allMailinglistsEntry){
			$this->addSelectedAttr($allMailinglistsEntry, $selectedMailinglists);
			$this->addUserInListAttr($allMailinglistsEntry, $userSubscribedMailinglists);
		}

		$this->view->assign('list', $allMailinglists);
		$this->view->assign('debug', $this);
	}

	/**
	* This function is called when the singleList Plugin is selected.
	* 
	*/

	public function singleListAction(){
		
		$selectedMailinglist = $this->settings['selectsinglemailinglist'];
		$mailinglist = $this->mailmanService->getSingleMailinglist($selectedMailinglist);
		$this->view->assign('mailinglist', $mailinglist);
		$this->view->assign('debug', $this);

	}

	/**
	* This function is called when a user wants to subscribe to a mailinglist with his own email.
	* the list_id is send via POST-request.
	* 
	*/
	public function subscribeAction(){
		
		//get the list_id from the GET-request
		$fqdn_list = $this->request->getArgument('list_id');

		//subscribe user to list
		$this->mailmanService->subscribe($fqdn_list, $this->usermail);

		//redirect to defined url
		$this->redirectToUri($this->redirectaddr);
	}

	/**
	* This function is called when a user wants to subscribe to a mailinglist with any email.
	* the list_id and the email is send via POST-request.
	* 
	*/
	public function singleListSubscribeAction(){
		
		//get the list_id from the GET-request
		$fqdn_list = $this->request->getArgument('list_id');
		$email = $this->request->getArgument('mail');

		//subscribe user to list
		$this->mailmanService->subscribe($fqdn_list, $email);

		//redirect to defined url
		$this->redirectToUri($this->mailmanConfig->redirectaddr);
	}

	/**
	* This function is called when a user wants to unsubscribe to a mailinglist with his own email.
	* the list_id is send via POST-request.
	* 
	*/
	public function unsubscribeAction(){

		//get the list_id from the GET-request
		$fqdn_list = $this->request->getArgument('list_id');

		//unsub user from list
		$this->mailmanService->unsubscribe($fqdn_list, $this->usermail);
		
		//redirect to defined url
		$this->redirectToUri($this->redirectaddr);
	}

	/**
	* This function works with {@link initializeAction()} to set the email of the logged in user.
	* you may want to override this function if youre not using TSFE.
	*
	* The usermail variable from the typoscript settings is just for testing purpose .
	*/
	public function setUserMail(){

		if(isset($this->settings['usermail'])){
			$this->usermail = $this->settings['usermail'];
		}else if(isset($GLOBALS['TSFE']->fe_user->user['email'])){
			$this->usermail =$GLOBALS['TSFE']->fe_user->user['email'];
		} 
	}

	/**
	* This function checks if the list is selected in the plugin conf and adds the "selected" attr to the object.
	* @param mixed[] &$mailinglist the reference to an mailinglist object
	* @param string[] $selectedListsInPlugin the selected list_ids from the Plugin
	*/
	private function addSelectedAttr(&$mailinglist,$selectedListsInPlugin){
		
		foreach ($selectedListsInPlugin as $key => $listID) {
			//checks if the list is selected 
			if($mailinglist->list_id == $listID){
				$mailinglist->selected = true;
				break;
			}else{
				$mailinglist->selected = false;
			}
		}
	}

	/**
	* This function checks if the user is subscribed to a mailinglist and adds the "userInList" attr to the object.
	* This helps to check in the html template if the user should subscribe or unsubscribe to a mailinglist.
	* @param mixed[] &$mailinglist the reference to an mailinglist object.
	* @param string[] $userSubscribedMailinglists all the lists the user subscribed to.
	*/
	private function addUserInListAttr(&$mailinglist, $userSubscribedMailinglists){
		
		if(is_array($userSubscribedMailinglists->entries)){
			foreach($userSubscribedMailinglists->entries as $userList){
				//checks if the user is subscribed to the list
				if($mailinglist->list_id == $userList->list_id && $userList->role == 'member'){
					$mailinglist->userInList = true;
					break;
				}else{
					$mailinglist->userInList = false;
				}	
			}
		}
	}

	/**
	 * Itemsproc function to extend the selection of mailingslists in the plugin
	 *
	 * @param array &$config configuration array
	 */
	public function availableMailingLists(array &$config) {
		$this->mailmanService = new MailmanService($this->usermail, $this->mailmanConfig);
		$allMailinglists = $this->mailmanService->getAllMailinglists();

		//add the mailinglists to the multiselect
		foreach($allMailinglists->entries as $list){
			$config['items'][] = [$list->list_id, $list->list_id];
		}
	}

}
