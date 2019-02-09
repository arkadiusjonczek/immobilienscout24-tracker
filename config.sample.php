<?php

// Sample config file

$config = array(
    'debug' => true,
    'search' => array(
        'include' => array(
            'new' => true,
            'changed' => false
        ),
        'exclude' => array(
            /* ignore following IDs */
        ),
        'state' => 'Nordrhein-Westfalen',
        'city' => 'Dortmund',
        'districts' => array(
            'Innenstadt', 'Dorstfeld'
        ),
        'area' => array(
            'min' => '',
            'max' => ''
        ),
        'rooms' => array(
            'min' => '',
            'max' => ''
        ),
        'rent' => array(
            'min' => '0',
            'max' => '400,00'
        )
    ),
    'search_url_pattern' => 'http://www.immobilienscout24.de/Suche/S-{sorting}/P-{page}/Wohnung-Miete/{state}/{city}/{districts}/{min_rooms}-{max_rooms}/{min_area}-{max_area}/EURO-{min_rent}-{max_rent}',
    'expose_url_pattern' => 'http://www.immobilienscout24.de/expose/{id}',
    'sqlite_file' => __DIR__ . DIRECTORY_SEPARATOR . 'immo24.sqlite',
    'email_template' => __DIR__ . DIRECTORY_SEPARATOR . 'email.template.php',
    'console_template' => __DIR__ . DIRECTORY_SEPARATOR . 'console.template.php',
    'mail_sender' => 'sender@email.com',
    'mail_receiver' => 'receiver@email.com',
    'mail_subject' => 'Immobilienscout24 - New Exposé'
);