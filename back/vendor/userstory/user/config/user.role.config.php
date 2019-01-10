<?php

use Userstory\User\components\UserRoleComponent;
use Userstory\User\entities\AuthAssignmentActiveRecord;
use Userstory\User\entities\AuthRoleActiveRecord;
use Userstory\User\entities\AuthRolePermissionActiveRecord;
use Userstory\User\models\AuthRolePermissionFormModel;
use Userstory\User\operations\AssignmentDeleteOperation;
use Userstory\User\operations\AssignmentGetOperation;
use Userstory\User\operations\AssignmentSaveOperation;
use Userstory\User\models\RolePermissionSaverModel;
use Userstory\User\queries\AuthAssignmentQuery;
use Userstory\User\queries\AuthRoleQuery;
use Userstory\User\queries\RolePermissionQuery;
use yii\data\ActiveDataProvider;

return [
    'class'        => UserRoleComponent::class,
    'modelClasses' => [
        'authRoleDataProvider'      => ActiveDataProvider::class,
        'authRoleForm'              => AuthRolePermissionFormModel::class,
        'authRoleQuery'             => AuthRoleQuery::class,
        'authRoleAR'                => AuthRoleActiveRecord::class,
        'authRolePermission'        => AuthRolePermissionActiveRecord::class,
        'rolePermissionQuery'       => RolePermissionQuery::class,
        'rolePermissionSaver'       => RolePermissionSaverModel::class,
        'authAssignmentQuery'       => AuthAssignmentQuery::class,
        'authAssignmentAR'          => AuthAssignmentActiveRecord::class,
        'assignmentSaveOperation'   => AssignmentSaveOperation::class,
        'assignmentDeleteOperation' => AssignmentDeleteOperation::class,
        'assignmentGetOperation'    => AssignmentGetOperation::class,
    ],
];
