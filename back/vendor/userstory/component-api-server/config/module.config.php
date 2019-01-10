<?php

use yii\web\JsonParser;
use Userstory\ComponentApiServer\logger\LogBehavior;
use Userstory\ComponentApiServer\models\rest\Response;
use Userstory\ComponentApiServer\controllers\ApiServerController;
use Userstory\ComponentApiServer\components\ApiServerComponent;

return [
    'controllerMap' => [
        'api-server' => [
            'class'                => ApiServerController::class,
            'enableCsrfValidation' => false,
        ],
    ],
    'bootstrap'     => ['apiServer'],
    'components'    => [
        'request'   => [
            'parsers' => [
                'application/json' => JsonParser::class,
            ],
        ],
        'apiServer' => [
            'class'          => ApiServerComponent::class,
            'response'       => Response::class,
            'defaultRules'   => [
                '[GET] <version>(/<language>)?/<resource>(/<action>)?'                             => 'api-server/rest-index',
                '[CREATE] <version>(/<language>)?/<resource>(/<action>)?'                          => 'api-server/rest-create',
                '[GET] <version>(/<language>)?/<resource>/<id>(/<action>)?'                        => 'api-server/rest-view',
                '[PUT] <version>(/<language>)?/<resource>/<id>(/<action>)?'                        => 'api-server/rest-update',
                '[DELETE] <version>(/<language>)?/<resource>/<id>(/<action>)?'                     => 'api-server/rest-delete',
                '[GET] <version>(/<language>)?/<resource>/<id>/<subresource>(/<action>)?'          => 'api-server/rest-sub-index',
                '[CREATE] <version>(/<language>)?/<resource>/<id>/<subresource>(/<action>)?'       => 'api-server/rest-sub-create',
                '[GET] <version>(/<language>)?/<resource>/<id>/<subresource>/<sid>(/<action>)?'    => 'api-server/rest-sub-view',
                '[PUT] <version>(/<language>)?/<resource>/<id>/<subresource>/<sid>(/<action>)?'    => 'api-server/rest-sub-update',
                '[DELETE] <version>(/<language>)?/<resource>/<id>/<subresource>/<sid>(/<action>)?' => 'api-server/rest-sub-delete',
                '[POST] <version>(/<language>)?/<resource>'                                        => 'api-server/rest-post',
                '[OPTIONS]'                                                                        => 'api-server/rest-options',
            ],
            'systemRules'    => [
                '[GET] system/info'           => 'api-server/rest-info',
                '[GET] <version>/system/info' => 'api-server/rest-info-version',
                '[GET] system/version'        => 'api-server/rest-version',
            ],
            'as log'         => [
                'class' => LogBehavior::class,
            ],
            'defaultMethod'  => 'POST',
            'defaultHeaders' => [
                'Access-Control-Allow-Origin'      => 'http://localhost',
                'Access-Control-Allow-Method'      => 'POST,GET,OPTIONS,PUT,DELETE,CREATE',
                'Access-Control-Allow-Headers'     => 'x-http-method-override,content-type',
                'Access-Control-Allow-Credentials' => 'true',
            ],
        ],
        'log'       => require __DIR__ . '/log.config.php',
    ],
];
