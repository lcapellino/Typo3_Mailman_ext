<?php
namespace Htwg\GiMailman;

require_once(__DIR__.'/GiExtUtil.php');

class GiMailman{
	
	public function getMailinglists() {
		return GiExtUtil::exec("getMailinglists.py");
	}

	public function subscribe() {
		return GiExtUtil::exec("subscribeUserToMailinglist.py test1@ct-gi.syslab.in.htwg-konstanz.de test@asdf.de 12345");;
	}

	public function unsubscribe() {
		return GiExtUtil::exec("unsubscribeUserToMailinglist.py test1@ct-gi.syslab.in.htwg-konstanz.de test@asdf.de");
	}

	public function addAddressToUser() {
		return GiExtUtil::exec("addAddressToUser.py bob@bob.com addressToBeAdded3@mail.com");
	}
}