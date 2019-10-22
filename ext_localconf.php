<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Htwg.Mailmanext',
	'listplugin',
	[
		'List' => 'multipleList,subscribe,unsubscribe',
	],
	// non-cacheable actions
	[
		'List' => 'multipleList,subscribe,unsubscribe',
	]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Htwg.Mailmanext',
	'singlelistplugin',
	[
		'List' => 'singlelist,singleListSubscribe',
	],
	// non-cacheable actions
	[
		'List' => 'singlelist,singleListSubscribe',
	]
);