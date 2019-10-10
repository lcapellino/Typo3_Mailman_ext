<?php
namespace Htwg\Mailmanext\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\RequestFactory;
use Htwg\Mailmanext\Domain\Model\MailmanConfig;

class Subscribe extends AbstractEntity
{
	public $mail='';
	public $list_id;
	private $mailmanConfig;


	public function __construct($mail,$list_id, $mailmanConfig){
		
		$this->mailmanConfig = $mailmanConfig;
		$this->mail = $mail;
		$this->list_id = $list_id;

		$requestFactory = GeneralUtility::makeInstance(RequestFactory::class);
		$url = $this->mailmanConfig->mailmanHost. 'members';
		
		$additionalOptions = [
			// Additional headers for this specific request
			'headers' => ['Cache-Control' => 'no-cache'],
			// Additional options, see http://docs.guzzlephp.org/en/latest/request-options.html
			'allow_redirects' => false,
			'auth' => [$this->mailmanConfig->mailmanUser,$this->mailmanConfig->mailmanPassword],
			'form_params' => [
				'subscriber' => $this->mail,
				'list_id' => $this->list_id,
				'display_name' => null,
				'pre_confirmed' => true,
				'pre_verified' => true,
			]
		];
		try {
  		$requestFactory->request($url, 'POST', $additionalOptions);
    } catch (\Exception $e){
      $logger = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
      $logger->error($e->getMessage());
    }  


	}
}
