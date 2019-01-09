<?php

declare(strict_types = 1);

use app\api\v1\actions\captcha\CaptchaAction;
use app\api\v1\actions\externalLanguage\ListAction as ExternalLanguageListAction;
use app\api\v1\actions\language\ListAction as LanguageListAction;
use app\api\v1\actions\publicScript\ViewAction;
use app\api\v1\actions\rating\ListAction as RatingListAction;
use app\api\v1\actions\timezone\ListAction as TimezoneListAction;
use app\api\v1\actions\translation\ListAction as TranslationListAction;

$config = [
    'id'         => 'TouchTV Core',
    'name'       => 'TouchTV',
    'homeUrl'    => 'http://demo.touch-tv-back.stands.userstory.ru',
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
        'apiServer'    => [
            'actions'        => [
                'v1' => [
                    'player-option/index'     => ViewAction::class,
                    'captcha/index'           => CaptchaAction::class,
                    'timezone/index'          => TimezoneListAction::class,
                    'rating/index'            => RatingListAction::class,
                    'external-language/index' => ExternalLanguageListAction::class,
                    'language/index'          => [
                        'class' => LanguageListAction::class,
                    ],
                    'translation/index'       => [
                        'class' => TranslationListAction::class,
                    ],
                ],
            ],
            'defaultHeaders' => [
                'Access-Control-Allow-Origin'      => null,
                'Access-Control-Allow-Method'      => null,
                'Access-Control-Allow-Headers'     => null,
                'Access-Control-Allow-Credentials' => null,
            ],
        ],
    ],
];

return $config;
