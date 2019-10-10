<?php
$EM_CONF[$_EXTKEY] = [
	'title' => 'Mailman Extension',
	'description' => 'An extension to manage mailman mailinglists',
	'category' => 'Plugin',
	'constraints' => [
		'depends' => [
			'typo3' => '8.7.0-9.5.99',
		],
		'conflicts' => [
		],
	],
	'autoload' => [
		'psr-4' => [
			'Htwg\\Mailmanext\\' => 'Classes'
		],
	],
	'state' => 'stable',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearCacheOnLoad' => 1,
	'author' => 'lucas capellino, mathias kupferschmid',
	'author_email' => 'lu721cap@htwg-konstanz.de',
	'author_company' => 'htwg',
	'version' => '1.1.4',
];
