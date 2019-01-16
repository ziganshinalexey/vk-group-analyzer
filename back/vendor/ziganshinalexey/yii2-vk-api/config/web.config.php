<?php

declare(strict_types = 1);

return [
    'components' => [
        'vkUser'  => require __DIR__ . '/user.component.global.php',
        'vkGroup' => require __DIR__ . '/group.component.global.php',
    ],
];
