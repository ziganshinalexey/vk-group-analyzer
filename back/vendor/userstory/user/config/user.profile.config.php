<?php

use Userstory\User\components\UserProfileComponent;
use Userstory\User\entities\AuthRoleActiveRecord;
use Userstory\User\entities\UserAuthActiveRecord;
use Userstory\User\entities\UserProfileActiveRecord;
use Userstory\User\entities\UserProfileSettingActiveRecord;
use Userstory\User\queries\AuthRoleQuery;
use Userstory\User\queries\UserAuthQuery;
use Userstory\User\queries\UserProfileQuery;
use Userstory\User\queries\UserProfileSettingsQuery;

return [
    'class'        => UserProfileComponent::class,
    'modelClasses' => [
        'userAuthModel'            => UserAuthActiveRecord::class,
        'userAuthQuery'            => UserAuthQuery::class,
        'userProfileModel'         => UserProfileActiveRecord::class,
        'userProfileQuery'         => UserProfileQuery::class,
        'userProfileSettingsModel' => UserProfileSettingActiveRecord::class,
        'userProfileSettingsQuery' => UserProfileSettingsQuery::class,
        'authRoleQuery'            => AuthRoleQuery::class,
        'authRoleAR'               => AuthRoleActiveRecord::class,
    ],
];
