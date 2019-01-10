<?php

declare(strict_types = 1);

$config = [
    'id'         => 'Person Analyzer',
    'name'       => 'Person Analyzer',
    'basePath'   => dirname(__DIR__),
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'language'   => 'ru',
    'bootstrap'  => ['log'],
    'components' => [
        'request'      => [
            'cookieValidationKey' => 'vC_BeH6kTR8ruoMlH8EdNx58fYDiyEKk',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [],
        ],
    ],
];

return $config;
