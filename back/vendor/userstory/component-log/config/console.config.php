<?php
use Userstory\ComponentLog\commands\LogCommand;

return [
    'components'    => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning',
                    ],
                ],
            ],
        ],
    ],
    'controllerMap' => [
        'logs' => [
            'class' => LogCommand::class,
        ],
    ],
];
