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
	public function mailingListAction(){
		$testuser = $usermail = $this->settings['usermail'];
    $fe_user_mail = $GLOBALS['TSFE']->fe_user->user['email'];
    if(isset($testuser)){
     // try {
      $list = new Mailinglists($testuser, $this->settings );
    /*} catch (\Exception $e){
      $logger = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
      $logger->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, $e->getMessage());
    }  */
		  $this->view->assign('list', $list);
    }else if(isset($fe_user_mail)){
      $list = new Mailinglists($fe_user_mail, $this->settings);
		  $this->view->assign('list', $list);
    } else {
      $this->view->assign('list', NULL);
    }
    
		$this->view->assign('debug', $list);
	}

	public function subscribeAction(){
		//get the current frontend usermail
		$usermail = $this->settings['usermail'];

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
		$usermail = $this->settings['usermail'];
		$fqdn_list = $this->request->getArgument('list_id');
		$sub = new Unsubscribe($usermail, $fqdn_list);

		$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mailmanext']);
		$redirectAddr = $extensionConfiguration['redirectAddr'];
		$this->redirectToUri($redirectAddr);
	}

}
