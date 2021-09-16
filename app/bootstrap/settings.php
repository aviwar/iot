<?php

return [
    'settings' => [
        'displayErrorDetails' => true,
        'maintenanceMode' => false,
        'view' => [
            'path' => __DIR__ . '/../view',
            'twig' => [
                'cache' => false
            ]
        ],
        'app_log' => __DIR__ . '/../../logs/',
		'app_name' => 'Iot',
        'db' => [
            'host' => '127.0.0.1',
            'name' => 'iot',
            'user' => 'root',
            'password' => ''
        ],
        'docs' => __DIR__ . '/../../docs/',
        'sms' => [
            'clientId' => '',
            'apiKey' => '',
            'senderId' => ''
        ],
    ],
];
