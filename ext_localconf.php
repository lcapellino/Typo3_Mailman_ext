<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Htwg.MailmanExt',
    'Pi1',
    [
        'MailmanExt' => 'mailingList',
    ],
    // non-cacheable actions
    [
        'MailmanExt' => '',
    ],
);
