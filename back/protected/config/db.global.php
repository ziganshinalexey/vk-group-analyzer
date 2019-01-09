<?php

use yii\db\Connection;

return [
    'components' => [
        'db' => [
            'class'             => Connection::class,
            'dsn'               => 'pgsql:host=db_1;port=5432;dbname=touch_tv_back',
            'username'          => 'postgres',
            'password'          => '123',
            'charset'           => 'utf8',
            'tablePrefix'       => 'tt_',
            'enableSchemaCache' => true,
            'slaveConfig'       => [
                'username'   => 'postgres',
                'password'   => '123',
                'attributes' => [
                    PDO::ATTR_TIMEOUT => 10,
                ],
            ],
            'slaves'            => [
                'main' => ['dsn' => 'pgsql:host=db_2;port=5432;dbname=touch_tv_back'],
            ],
        ],
    ],
];
