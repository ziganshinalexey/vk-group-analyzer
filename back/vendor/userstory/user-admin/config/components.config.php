<?php

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\UserAdmin\components\UserAdminComponent;
use Userstory\UserAdmin\factories\UserAdminFactory as ModelsFactory;
use Userstory\UserAdmin\forms\LoginForm;
use Userstory\UserAdmin\forms\RecoveryForm;
use Userstory\UserAdmin\operations\NotifyOperation;
use Userstory\UserAdmin\operations\CommonOperation;
use Userstory\UserAdmin\forms\PermissionForm;
use Userstory\UserAdmin\forms\RoleForm;
use yii\data\ActiveDataProvider;
use Userstory\UserAdmin\forms\UserProfileForm;

return [
    'userAdmin'     => [
        'class'                                           => UserAdminComponent::class,
        ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
            'class'                              => ModelsFactory::class,
            ModelsFactory::MODEL_CONFIG_LIST_KEY => [
                'loginForm'       => [
                    ModelsFactory::OBJECT_TYPE_KEY => LoginForm::class,
                ],
                'recoveryForm'    => [
                    ModelsFactory::OBJECT_TYPE_KEY => RecoveryForm::class,
                ],
                'roleForm'        => [
                    ModelsFactory::OBJECT_TYPE_KEY => RoleForm::class,
                ],
                'permissionForm'  => [
                    ModelsFactory::OBJECT_TYPE_KEY => PermissionForm::class,
                ],
                'userProfileForm' => [
                    ModelsFactory::OBJECT_TYPE_KEY => UserProfileForm::class,
                ],
                'notifyOperation' => [
                    ModelsFactory::OBJECT_TYPE_KEY => [
                        'class'           => NotifyOperation::class,
                        'emailFrom'       => 'web@dev.userstory.ru',
                        'emailFromName'   => 'Сайт',
                        'emailSubject'    => 'Ваш аккаунт активирован',
                        'emailText'       => [
                            'Ваш аккаунт активирован.',
                            'Чтобы воспользоваться сервисами, перейдите на сайт.',
                            'С уважением, администрация.',
                        ],
                        'smsText'         => 'Ваш аккаунт активирован',
                        'isActivateEmail' => true,
                        'isActivateSms'   => false,
                    ],
                ],
                'commonOperation' => [
                    ModelsFactory::OBJECT_TYPE_KEY => [
                        'class' => CommonOperation::class,
                    ],
                ],
                'dataProvider'    => [
                    ModelsFactory::OBJECT_TYPE_KEY => ActiveDataProvider::class,
                ],
            ],
        ],
    ],
    'competingView' => [
        'allowedEntities' => [
            'userProfile',
            'authAssignment',
            'authRolePermission',
            'authRole',
        ],
    ],
    'urlManager'    => [
        'rules' => [
            'admin/profile' => 'profile',
        ],
    ],
    'menu'          => [
        'items' => [
            'admin' => [
                'user'      => [
                    'title'      => 'Пользователи',
                    'icon'       => 'fa fa-user',
                    'route'      => '/admin/user',
                    'permission' => 'User.Profile.Read',
                ],
                'auth-role' => [
                    'title'      => 'Роли',
                    'icon'       => 'fa fa-cogs',
                    'route'      => '/admin/auth-role',
                    'permission' => 'User.Role.Read',
                ],
            ],
        ],
    ],
];
