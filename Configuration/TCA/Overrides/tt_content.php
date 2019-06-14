<?php

    
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['mailmanext_pil'] = 'select_key,pages,recursive';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['mailmanext_pil'] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'mailmanext_pil',
    'FILE:EXT:mailmanext/Configuration/FlexForms/pil.xml'
);