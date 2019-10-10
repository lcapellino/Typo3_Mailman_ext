<?php

defined('TYPO3_MODE') or die();



\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'mailmanext',
	'listplugin',
	'Mailman Mailinglists',
	'EXT:mailmanext/ext_icon.png'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['mailmanext_listplugin'] = 'select_key,pages,recursive';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['mailmanext_listplugin'] = 'pi_flexform';



\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
	'mailmanext_listplugin',
	'FILE:EXT:mailmanext/Configuration/FlexForms/listplugin.xml'
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:mailmanext/Configuration/TSconfig/ContentElementWizard.txt">');


$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
	'ext_icon',
	\TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
	['source' => 'EXT:mailmanext/ext_icon.png']
);

