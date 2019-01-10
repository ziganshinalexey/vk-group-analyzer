<?php

use Userstory\ModuleAdmin\AdminModule;
use Userstory\ModuleAdmin\components\Automenu;
use Userstory\ModuleAdmin\components\View;
use Userstory\ModuleAdmin\controllers\AdminController;

return [
    'components' => [
        'view'       => [
            'class' => View::class,
        ],
        'menu'       => [
            'class' => Automenu::class,
        ],
        'urlManager' => [
            'rules' => [
                'admin'                               => 'admin/admin',
                'admin/logout'                        => '/admin/admin/logout',
                'admin/<controller:\w+>'              => 'admin/<controller>',
                'admin/<controller:\w+>/<action:\w+>' => 'admin/<controller>/<action>',
            ],
        ],
    ],
    'modules'    => [
        'admin' => [
            'class'         => AdminModule::class,
            'controllerMap' => [
                'admin' => [
                    'class'     => AdminController::class,
                    'layout'    => 'main.php',
                    'viewMap'   => [
                        'login' => '@app/views/main/login.php',
                    ],
                    'layoutMap' => [
                        'login' => '@app/views/layouts/login.php',
                    ],
                ],
            ],
            'loginUrl'      => ['/login'],
        ],
    ],
    'params'     => [
        'adminRoute' => '/admin',
    ],
];
