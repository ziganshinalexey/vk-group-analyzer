<?php

return [
    'controllerMap' => [
        'migrate' => [
            'migrationPathList' => ['@vendor/userstory/i18n/migrations'],
        ],
    ],
    'components'    => require_once 'components.config.php',
];
