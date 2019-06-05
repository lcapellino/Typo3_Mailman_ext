<?php

namespace Htwg\Mailmanext\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Htwg\Mailmanext\Domain\Model\Mailinglists;
use Htwg\Mailmanext\Domain\Model\Subscribe;
use Htwg\Mailmanext\Domain\Model\Unsubscribe;


class MailmanExtController extends ActionController{
 
    
    /**
     * List Action
     *
     * @return void
     */
    public function mailingListAction(){
		$usermail = $this->settings['usermail'];
//		$usermail = 'test@asdf.de';
        $list = new Mailinglists($usermail);
        //$list = $this;
        $this->view->assign('list', $list);
    }

    public function subscribeAction(){
        $usermail = $this->settings['usermail'];
        $fqdn_list = $this->request->getArgument('fqdn_listname');
        $sub =new Subscribe($usermail, $fqdn_list);
        $redirectAddr = $extensionConfiguration['redirectAddr'];
        //$this->redirectToUri($redirectAddr);
		$this->view->assign('param', $sub);
    }

	public function unsubscribeAction(){
        $usermail = $this->settings['usermail'];
        $fqdn_list = $this->request->getArgument('fqdn_listname');
        $sub = new Unsubscribe($usermail, $fqdn_list);
		$this->view->assign('param', $this->request->getArguments());
    }
/*
    public function subscribe() {
        return \GiExtUtil::exec("subscribeUserToMailinglist.py test1@ct-gi.syslab.in.htwg-konstanz.de test@asdf.de 12345");;
    }

    public function unsubscribe() {
        return \GiExtUtil::exec("unsubscribeUserToMailinglist.py test1@ct-gi.syslab.in.htwg-konstanz.de test@asdf.de");
    }

    public function addAddressToUser() {
        return \GiExtUtil::exec("addAddressToUser.py bob@bob.com addressToBeAdded3@mail.com");
    }
*/

}
