<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Htwg.GiMailman',
    'Pi1',
    [
        'GiMailman' => 'mailingList',
    ],
    // non-cacheable actions
    [
        'GiMailman' => '',
    ],
);