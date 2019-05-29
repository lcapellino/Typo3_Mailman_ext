<?php

namespace Htwg\Mailmanext\Controller;

use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Htwg\Mailmanext\Domain\Model\Mailinglists;


class MailmanExtController extends ActionController
{
 
    
    /**
     * List Action
     *
     * @return void
     */
    public function mailingListAction()
    {

        $list = new Mailinglists('test@asdf.de');
        //$list = $this;
        $this->view->assign('list', $list);
    }



    public function subscribe() {
        return \GiExtUtil::exec("subscribeUserToMailinglist.py test1@ct-gi.syslab.in.htwg-konstanz.de test@asdf.de 12345");;
    }

    public function unsubscribe() {
        return \GiExtUtil::exec("unsubscribeUserToMailinglist.py test1@ct-gi.syslab.in.htwg-konstanz.de test@asdf.de");
    }

    public function addAddressToUser() {
        return \GiExtUtil::exec("addAddressToUser.py bob@bob.com addressToBeAdded3@mail.com");
    }

}
