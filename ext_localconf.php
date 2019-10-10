<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Htwg.Mailmanext',
	'listplugin',
	[
		'List' => 'list,subscribe,unsubscribe',
	],
	// non-cacheable actions
	[
		'List' => 'subscribe,unsubscribe,list',
	]
);
