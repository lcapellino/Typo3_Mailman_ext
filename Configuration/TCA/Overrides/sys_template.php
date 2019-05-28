<?php
defined('TYPO3_MODE') || die();

call_user_func(function()
{
   /**
    * Extension key
    */
   $extensionKey = 'gi_mailman';

   /**
    * Default TypoScript
    */
   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
      $extensionKey,
      'Configuration/TypoScript',
      'GiMailman'
   );
});