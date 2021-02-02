<?php

return [
    'settings' => [
        'displayErrorDetails' => true,
        'maintenanceMode' => false,
        'view' => [
            'path' => __DIR__ . '/../view',
            'twig' => [
                'cache' => false,
            ],
        ],
        'app_log' => __DIR__ . '/../../logs/app.log',
        'app_name' => 'Iot',
        'db' => [
            'host' => '127.0.0.1',
            'name' => 'iot',
            'user' => 'root',
            'password' => '',
        ],
        'sms' => [
            'clientId' => '',
            'apiKey' => '',
            'senderId' => '',
        ],
    ],
];
