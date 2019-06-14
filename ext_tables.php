<?php

defined('TYPO3_MODE') or die();

$boot= function(){

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	    'mailmanext',
	    'Pi1',
	    'Mailman Mailinglists',
	    'EXT:mailmanext/ext_icon.png'
	);




    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:mailmanext/Configuration/TSconfig/ContentElementWizard.txt">');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
      'mailmanext',
      'Configuration/TypoScript',
      'Mailman Extension'
   );

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'ext_icon',
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        ['source' => 'EXT:mailmanext/ext_icon.png']
    );

};

$boot();
unset($boot);