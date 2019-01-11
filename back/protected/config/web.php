<?php

declare(strict_types = 1);

use app\api\v1\actions\vk\AnalyzeAction;
use app\api\v1\formatters\vk\Formatter;

$config = [
    'id'         => 'Person Analyzer',
    'name'       => 'Person Analyzer',
    'basePath'   => dirname(__DIR__),
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'language'   => 'ru',
    'bootstrap'  => ['log'],
    'aliases'    => [
        '@bower' => dirname(__DIR__, 2) . '/vendor/bower-asset',
    ],
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
        'apiServer'    => [
            'actions' => [
                'v1' => [
                    'analyze/index' => [
                        'class'     => AnalyzeAction::class,
                        'formatter' => Formatter::class,
                    ],
                ],
            ],
        ],
    ],
];

return $config;
