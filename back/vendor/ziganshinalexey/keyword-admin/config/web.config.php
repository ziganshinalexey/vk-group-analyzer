<?php

declare(strict_types = 1);

use Ziganshinalexey\KeywordAdmin\controllers\KeywordController;

return [
    'components' => [
        'competingView' => require __DIR__ . '/competingView.component.global.php',
        'menu'          => require __DIR__ . '/menu.component.global.php',
        'authManager'   => require __DIR__ . '/authManager.component.global.php',
        'keywordAdmin'  => require __DIR__ . '/keywordAdmin.component.global.php',
    ],
    'modules'    => [
        'admin' => [
            'controllerMap' => [
                'keyword' => [
                    'class'       => KeywordController::class,
                    'layout'      => '@vendor/userstory/module-admin/views/layouts/main',
                    'viewMap'     => [
                        'index'  => '@vendor/ziganshinalexey/keyword-admin/views/keyword/index',
                        'view'   => '@vendor/ziganshinalexey/keyword-admin/views/keyword/view',
                        'create' => '@vendor/ziganshinalexey/keyword-admin/views/keyword/create',
                        'update' => '@vendor/ziganshinalexey/keyword-admin/views/keyword/update',
                    ],
                    'ajaxActions' => ['create'],
                ],
            ],
        ],
    ],
];
