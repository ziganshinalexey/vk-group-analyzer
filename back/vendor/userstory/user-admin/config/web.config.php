<?php

use Userstory\User\entities\AuthAssignmentActiveRecord;
use Userstory\UserAdmin\controllers\AuthAssignmentController;
use Userstory\UserAdmin\controllers\AuthRoleController;
use Userstory\UserAdmin\controllers\AuthRolePermissionController;
use Userstory\UserAdmin\controllers\LoginController;
use Userstory\UserAdmin\controllers\ProfileController;
use Userstory\UserAdmin\controllers\RecoveryController;
use Userstory\UserAdmin\controllers\UserController;
use Userstory\UserAdmin\models\LoginViewModel;
use Userstory\UserAdmin\forms\RoleForm;

return [
    'components'    => require __DIR__ . '/components.config.php',
    'modules'       => [
        'admin' => [
            'controllerMap' => [
                'user'                 => [
                    'class'   => UserController::class,
                    'layout'  => '@vendor/userstory/module-admin/views/layouts/main',
                    'viewMap' => [
                        'index'  => '@vendor/userstory/user-admin/views/user/index',
                        'view'   => '@vendor/userstory/user-admin/views/user/view',
                        'update' => '@vendor/userstory/user-admin/views/user/update',
                        'create' => '@vendor/userstory/user-admin/views/user/create',
                    ],
                ],
                'auth-role'            => [
                    'class'      => AuthRoleController::class,
                    'layout'     => '@vendor/userstory/module-admin/views/layouts/main',
                    'viewMap'    => [
                        'index'  => '@vendor/userstory/user-admin/views/auth-role/index',
                        'view'   => '@vendor/userstory/user-admin/views/auth-role/view',
                        'update' => '@vendor/userstory/user-admin/views/auth-role/update',
                        'create' => '@vendor/userstory/user-admin/views/auth-role/create',
                    ],
                    'modelClass' => RoleForm::class,
                ],
                'auth-assignment'      => [
                    'class'      => AuthAssignmentController::class,
                    'layout'     => '@vendor/userstory/module-admin/views/layouts/main',
                    'viewMap'    => [
                        'index'  => '@vendor/userstory/user-admin/views/auth-assignment/index',
                        'view'   => '@vendor/userstory/user-admin/views/auth-assignment/view',
                        'update' => '@vendor/userstory/user-admin/views/auth-assignment/update',
                        'create' => '@vendor/userstory/user-admin/views/auth-assignment/create',
                    ],
                    'modelClass' => AuthAssignmentActiveRecord::class,
                ],
                'auth-role-permission' => [
                    'class'   => AuthRolePermissionController::class,
                    'layout'  => '@vendor/userstory/module-admin/views/layouts/main',
                    'viewMap' => [
                        'index'  => '@vendor/userstory/user-admin/views/auth-role-permission/index',
                        'view'   => '@vendor/userstory/user-admin/views/auth-role-permission/view',
                        'update' => '@vendor/userstory/user-admin/views/auth-role-permission/update',
                        'create' => '@vendor/userstory/user-admin/views/auth-role-permission/create',
                    ],
                ],
            ],
        ],
    ],
    'controllerMap' => [
        'recovery' => [
            'class'   => RecoveryController::class,
            'viewMap' => [
                'index'             => '@vendor/userstory/user-admin/views/recovery/index',
                'change'            => '@vendor/userstory/user-admin/views/recovery/change',
                'option'            => '@vendor/userstory/user-admin/views/recovery/option',
                'success'           => '@vendor/userstory/user-admin/views/recovery/success',
                'email-recovery'    => '@vendor/userstory/user/views/emails/email-recovery',
                'password-recovery' => '@vendor/userstory/user/views/emails/password-recovery',
            ],
        ],
        'login'    => [
            'class'        => LoginController::class,
            'viewMap'      => [
                'index' => '@vendor/userstory/user-admin/views/login/index',
            ],
            'layoutMap'    => [
                'index' => '@vendor/userstory/user-admin/views/layouts/login',
            ],
            'modelViewMap' => [
                'index' => LoginViewModel::class,
            ],
        ],
        'profile'  => [
            'class'   => ProfileController::class,
            'layout'  => '@vendor/userstory/module-admin/views/layouts/main',
            'viewMap' => [
                'index' => '@vendor/userstory/user-admin/views/profile/index',
            ],
        ],
    ],
];
