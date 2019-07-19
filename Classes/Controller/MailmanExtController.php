<?php

namespace Htwg\Mailmanext\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Htwg\Mailmanext\Domain\Model\Mailinglists;
use Htwg\Mailmanext\Domain\Model\Subscribe;
use Htwg\Mailmanext\Domain\Model\Unsubscribe;


class MailmanExtController extends ActionController{

	/*
	This function shows all Mailinglists by 
	showing the view of Mailingslists from
	/Resources/Private/Templates/MailingList.html
	*/
  public $usermail = "";
  
	public function mailingListAction(){
    $usermail = "";
    if(isset($this->settings['usermail'])){
      $usermail = $this->settings['usermail'];
    }else if(isset($GLOBALS['TSFE']->fe_user->user['email'])){
      $usermail =$GLOBALS['TSFE']->fe_user->user['email'];
    } 

    $list = new Mailinglists($usermail, $this->settings );
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
		$sub = new Subscribe($usermail, $fqdn_list);

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
		$sub = new Unsubscribe($usermail, $fqdn_list);

		$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mailmanext']);
		$redirectAddr = $extensionConfiguration['redirectAddr'];
		$this->redirectToUri($redirectAddr);
	}

}
