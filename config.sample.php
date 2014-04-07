<?php

// Sample config file

$config = array(
    'debug' => false,
	'search' => array(
		'state' => 'Nordrhein-Westfalen',
		'city' => 'Dortmund',
		'district' => array(
			'Innenstadt', 'Dorstfeld'
		),
		'base_rent' => '400,00'
	),
	'url_pattern' => 'http://www.immobilienscout24.de/Suche/S-T/P-{page}/Wohnung-Miete/{state}/{city}/{district}/-/-/EURO--{base_rent}',
    'sqlite_file' => __DIR__ . DIRECTORY_SEPARATOR . 'immo24.sqlite',
    'template' => __DIR__ . DIRECTORY_SEPARATOR . 'email.template.php',
    'mail_sender' => 'sender@email.com',
    'mail_receiver' => 'receiver@email.com',
    'mail_subject' => 'Immobilienscout24 - New Exposé'
);