<?php

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\User\components\UserComponent;
use Userstory\User\factories\UserFactory;
use yii\db\Connection;
use yii\db\Query;
use yii\base\Event;
use yii\db\Expression;
use Userstory\User\models\ResultModel;

$sqliteDefaultDir = dirname(dirname(dirname(dirname(__DIR__)))) . '/protected/runtime';

return [
    'dbSqlite' => [
        'class' => Connection::class,
        'dsn'   => 'sqlite:' . $sqliteDefaultDir . '/sqlite.db',
    ],
    'userBase' => [
        'class'                                           => UserComponent::class,
        'captchaConfig'                                   => require __DIR__ . '/captcha.config.php',
        ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
            'class'                              => UserFactory::class,
            ModelsFactory::MODEL_CONFIG_LIST_KEY => [
                'queryObject' => [
                    ModelsFactory::OBJECT_TYPE_KEY => Query::class,
                ],
                'event'       => [
                    ModelsFactory::OBJECT_TYPE_KEY => Event::class,
                ],
                'expression'  => [
                    ModelsFactory::OBJECT_TYPE_KEY   => Expression::class,
                    ModelsFactory::OBJECT_PARAMS_KEY => [''],
                ],
                'result'      => [
                    ModelsFactory::OBJECT_TYPE_KEY => ResultModel::class,
                ],
            ],
        ],
    ],
];
