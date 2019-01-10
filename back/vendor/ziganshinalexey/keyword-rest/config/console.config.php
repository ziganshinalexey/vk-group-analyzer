<?php

declare(strict_types = 1);

return [
    'components'    => [
        'keywordRest' => require __DIR__ . '/keywordRest.component.global.php',
    ],
    'controllerMap' => [
        'migrate' => [
            'migrationPathList' => ['@vendor/ziganshinalexey/keyword-rest/migrations'],
        ],
    ],
];
