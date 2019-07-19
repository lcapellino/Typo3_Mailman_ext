<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Htwg.Mailmanext',
	'Pil',
	[
		'MailmanExt' => 'mailingList,subscribe,unsubscribe',
	],
	// non-cacheable actions
	[
		'MailmanExt' => 'subscribe,unsubscribe,mailingList',
	]
);
