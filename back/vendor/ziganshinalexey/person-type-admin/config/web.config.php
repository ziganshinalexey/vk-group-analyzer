<?php

declare(strict_types = 1);

use Ziganshinalexey\PersonTypeAdmin\controllers\PersonTypeController;

return [
    'components' => [
        'competingView'   => require __DIR__ . '/competingView.component.global.php',
        'menu'            => require __DIR__ . '/menu.component.global.php',
        'authManager'     => require __DIR__ . '/authManager.component.global.php',
        'personTypeAdmin' => require __DIR__ . '/personTypeAdmin.component.global.php',
    ],
    'modules'    => [
        'admin' => [
            'controllerMap' => [
                'person-type' => [
                    'class'       => PersonTypeController::class,
                    'layout'      => '@vendor/userstory/module-admin/views/layouts/main',
                    'viewMap'     => [
                        'index'  => '@vendor/ziganshinalexey/person-type-admin/views/personType/index',
                        'view'   => '@vendor/ziganshinalexey/person-type-admin/views/personType/view',
                        'create' => '@vendor/ziganshinalexey/person-type-admin/views/personType/create',
                        'update' => '@vendor/ziganshinalexey/person-type-admin/views/personType/update',
                    ],
                    'ajaxActions' => ['create'],
                ],
            ],
        ],
    ],
];
