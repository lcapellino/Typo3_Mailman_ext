<?php

namespace Htwg\Mailmanext\Hooks;


use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\RequestFactory;

class ItemsProcFunc{
    /**
     * Itemsproc function to extend the selection of order fields in the plugin
     *
     * @param array &$config configuration array
     */
    public function availableMailingLists(array &$config)    {

		$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mailmanext']);
        $this->mailmanHost = $extensionConfiguration['mailman.']['mailmanhost'];
        $this->mailmanUser = $extensionConfiguration['mailman.']['mailmanuser'];
        $this->mailmanPassword = $extensionConfiguration['mailman.']['mailmanpassword'];
        

		$requestFactory = GeneralUtility::makeInstance(RequestFactory::class);

		$url = $this->mailmanHost. 'lists';
		$additionalOptions = [
	   'headers' => ['Cache-Control' => 'no-cache'],
	   'allow_redirects' => false,
	   'auth' => [$this->mailmanUser,$this->mailmanPassword],
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