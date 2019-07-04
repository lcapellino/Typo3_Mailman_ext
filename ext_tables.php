<?php

defined('TYPO3_MODE') or die();



\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'mailmanext',
	'Pil',
	'Mailman Mailinglists',
	'EXT:mailmanext/ext_icon.png'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['mailmanext_pil'] = 'select_key,pages,recursive';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['mailmanext_pil'] = 'pi_flexform';



\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
	'mailmanext_pil',
	'FILE:EXT:mailmanext/Configuration/FlexForms/pil.xml'
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

