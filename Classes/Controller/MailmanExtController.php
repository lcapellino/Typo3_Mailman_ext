<?php

namespace Htwg\Mailmanext\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
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
		$usermail = $this->settings['usermail'];
		$list = new Mailinglists($usermail, $this->settings);
		$this->view->assign('list', $list);
		$this->view->assign('debug', $this);
	}

	public function subscribeAction(){
		//get the current frontend usermail
		$usermail = $this->settings['usermail'];

		//get the list_id from the GET-request
		$fqdn_list = $this->request->getArgument('list_id');

		//subscribe user to list
		$sub = new Subscribe($usermail, $fqdn_list);

		//redirect to defined url
		$redirectAddr = $extensionConfiguration['redirectAddr'];
		$this->redirectToUri($redirectAddr);
	}

	public function unsubscribeAction(){
		$usermail = $this->settings['usermail'];
		$fqdn_list = $this->request->getArgument('list_id');
		$sub = new Unsubscribe($usermail, $fqdn_list);

		$redirectAddr = $extensionConfiguration['redirectAddr'];
		$this->redirectToUri($redirectAddr);
	}

}
