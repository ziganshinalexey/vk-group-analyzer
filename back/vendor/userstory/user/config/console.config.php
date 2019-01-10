<?php

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\User\commands\UserCommand;
use Userstory\User\components\AuthenticationComponent;
use Userstory\User\components\AuthorizationComponent;
use Userstory\User\components\UserProfileRedisComponent;
use Userstory\User\components\UserRoleCacheComponent;
use Userstory\User\operations\AuthorizationOperation;

return [
    'components'    => ArrayHelper::merge([
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
        'authManager'           => [
            'class'     => AuthorizationComponent::class,
            'guestRole' => 'guest',
            'operation' => [
                'class' => AuthorizationOperation::class,
            ],
        ],
        'authenticationService' => [
            'class' => AuthenticationComponent::class,
        ],
    ], require __DIR__ . '/user.config.php'),
    'controllerMap' => [
        'migrate' => [
            'migrationPathList' => ['@vendor/userstory/user/migrations'],
        ],
        'user'    => [
            'class' => UserCommand::class,
        ],
    ],
];
