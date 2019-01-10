<?php

use Userstory\ModuleMailer\commands\SendCommand;

return [
    'controllerMap' => [
        'migrate' => [
            'migrationPathList' => ['@vendor/userstory/module-mailer/migrations'],
        ],
        'send'    => [
            'class' => SendCommand::class,
        ],
    ],
    'components'    => require __DIR__ . '/components.php',
];
