<?php

/**
 * Extension Manager/Repository config file for ext "gi_mailman".
 */
$EM_CONF[$_EXTKEY] = [
    'title' => 'gi mailman',
    'description' => 'An extension to manage mailman mailinglists',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.5.99',
            'rte_ckeditor' => '8.7.0-9.5.99',
            'bootstrap_package' => '10.0.0-10.0.99'
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Htwg\\GiMailman\\' => 'Classes'
        ],
    ],
    'state' => 'alpha',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'lucas capellino, mathias kupferschmid',
    'author_email' => 'lu721cap@htwg-konstanz.de',
    'author_company' => 'htwg',
    'version' => '1.0.0',
];
