<?php
use Userstory\ComponentLog\loggers\FileTarget;
use Userstory\ModuleSms\components\Sms;
use Userstory\ModuleSms\models\AbstractProvider;

return [
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class'        => FileTarget::class,
                    'levels'       => ['info'],
                    'categories'   => [AbstractProvider::LOG_CATEGORY_NAME],
                    'logPath'      => '@app/runtime/sms',
                    'templatePath' => '@vendor/userstory/module-sms/templateLog/default.php',
                    'daysLife'     => 180,
                ],
            ],
        ],
        'sms' => [
            'class' => Sms::class,
            'debug' => false,
        ],
    ],
];
