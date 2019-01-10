<?php

declare(strict_types = 1);

return [
    'components' => [
        'apiServer'      => require __DIR__ . '/apiServer.component.global.php',
        'authManager'    => require __DIR__ . '/authManager.component.global.php',
        'personTypeRest' => require __DIR__ . '/personTypeRest.component.global.php',
    ],
];
