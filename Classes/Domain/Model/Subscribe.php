<?php
namespace Htwg\Mailmanext\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\RequestFactory;

class Subscribe extends AbstractEntity
{
	public $mail='';
	public $list_id;
	private $mailmanHost;
	private $mailmanUser;
	private $mailmanPassword;


	public function __construct($mail,$list_id ){
		$extensionConfiguration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mailmanext']);
		$this->mailmanHost = $extensionConfiguration['mailman.']['mailmanhost'];
		$this->mailmanUser = $extensionConfiguration['mailman.']['mailmanuser'];
		$this->mailmanPassword = $extensionConfiguration['mailman.']['mailmanpassword'];
		$this->mail = $mail;
		$this->list_id = $list_id;

		$requestFactory = GeneralUtility::makeInstance(RequestFactory::class);
		$url = $this->mailmanHost. 'members';
		
		$additionalOptions = [
			// Additional headers for this specific request
			'headers' => ['Cache-Control' => 'no-cache'],
			// Additional options, see http://docs.guzzlephp.org/en/latest/request-options.html
			'allow_redirects' => false,
			'auth' => [$this->mailmanUser,$this->mailmanPassword],
			'form_params' => [
				'subscriber' => $this->mail,
				'list_id' => $this->list_id,
				'display_name' => null,
				'pre_confirmed' => true,
				'pre_verified' => true,
			]
		];
		
		$response = $requestFactory->request($url, 'POST', $additionalOptions);
	
		// Get the content as a string on a successful request
		if ($response->getStatusCode() === 200) {
			if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0) {
				$content = $response->getBody()->getContents();
			}
		}
		$this->json =  json_decode($content);
	}
}
