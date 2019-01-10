<?php

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\User\components\AuthenticationComponent;
use Userstory\User\components\AuthorizationComponent;
use Userstory\User\components\UserAuthComponent;
use Userstory\User\components\UserIdentityComponent;
use Userstory\User\components\UserProfileRedisComponent;
use Userstory\User\components\UserProfileSearchComponent;
use Userstory\User\components\UserRoleCacheComponent;
use Userstory\User\entities\UserAuthActiveRecord;
use Userstory\User\entities\UserProfileActiveRecord;
use Userstory\User\factories\ModelUserProfileSearchFactory;
use Userstory\User\models\SearchProfileModel;
use Userstory\User\operations\AuthorizationOperation;
use Userstory\User\queries\UserAuthQuery;
use Userstory\User\queries\UserProfileQuery;

return ArrayHelper::merge([
    'userRole'              => require __DIR__ . '/user.role.config.php',
    'userProfile'           => require __DIR__ . '/user.profile.config.php',
    'userProfileCache'      => [
        'class'    => UserProfileRedisComponent::class,
        'required' => false,
    ],
    'userRoleCache'         => [
        'class'    => UserRoleCacheComponent::class,
        'required' => false,
    ],
    'userAuth'              => [
        'class'        => UserAuthComponent::class,
        'modelClasses' => [
            'model' => UserAuthActiveRecord::class,
            'query' => UserAuthQuery::class,
        ],
    ],
    'userProfileSearch'     => [
        'class'                                           => UserProfileSearchComponent::class,
        ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
            'class'                              => ModelUserProfileSearchFactory::class,
            ModelsFactory::MODEL_CONFIG_LIST_KEY => [
                'userProfileQuery'  => [
                    ModelsFactory::OBJECT_TYPE_KEY   => UserProfileQuery::class,
                    ModelsFactory::OBJECT_PARAMS_KEY => UserProfileActiveRecord::class,
                ],
                'userProfileSearch' => [
                    ModelsFactory::OBJECT_TYPE_KEY => SearchProfileModel::class,
                ],
            ],
        ],
    ],
    // Сервисы авторизации.
    'authManager'           => [
        'class'           => AuthorizationComponent::class,
        'permissionsList' => [
            'User.Admin.Access'             => 'Разрешение на доступ к административному модулю',
            'User.Profile.Create'           => 'Разрешение на создание пользователей',
            'User.Profile.Read'             => 'Разрешение на чтение пользователей',
            'User.Profile.Update'           => 'Разрешение на редактирование пользователей',
            'User.Profile.Delete'           => 'Разрешение на удаление пользователя',
            'User.Role.Read'                => 'Разрешение на чтение ролей',
            'User.Role.Create'              => 'Разрешение на создание ролей',
            'User.Role.Update'              => 'Разрешение на редактирование ролей',
            'User.Role.Delete'              => 'Разрешение на удаление ролей',
            'User.RoleAssignment.Read'      => 'Разрешение на чтение связей ролей и пользователей',
            'User.RoleAssignment.Create'    => 'Разрешение на назначение роли пользователю',
            'User.RoleAssignment.Update'    => 'Разрешение на реадктирование ролей пользователя',
            'User.RoleAssignment.Delete'    => 'Разрешение на удаление ролей пользователя',
            'User.RolePermission.Read'      => 'Разрешение на получение полномочий ролей',
            'User.RolePermission.Create'    => 'Разрешение на создание полномочия роли',
            'User.RolePermission.Update'    => 'Разрешение на обновление полномочия роли',
            'User.RolePermission.Delete'    => 'Разрешение на удаления полномочия роли',
            'User.Profile.List'             => 'Разрешение на чтение полного списка пользователей',
            'User.Profile.Login'            => 'Разрешение на авторизацию в системе',
            'User.Profile.Logout'           => 'Разрешение на выход из системы',
            'User.Profile.ChangePassword'   => 'Разрешение на смену пароля пользователя',
            'User.Profile.SendRecoveryCode' => 'Разрешение на отправку кода для восстановления пароля',
        ],
        'guestRole'       => 'guest',
        'operation'       => [
            'class' => AuthorizationOperation::class,
        ],
    ],
    'authenticationService' => [
        'class' => AuthenticationComponent::class,
    ],
    'user'                  => [
        'class'           => UserIdentityComponent::class,
        'identityClass'   => UserAuthActiveRecord::class,
        'enableAutoLogin' => true,
        'loginUrl'        => ['/login'],
    ],
], require __DIR__ . '/user.config.php');
