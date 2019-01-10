<?php

namespace Userstory\UserAdmin\forms;

use Userstory\User\models\AuthRolePermissionFormModel;
use Userstory\User\entities\AuthRolePermissionActiveRecord;

/**
 * Class AuthRolePermissionForm.
 * Расширенный для админки класс формы управления полномочиями роли.
 *
 * @package Userstory\UserAdmin\forms
 */
class AuthRolePermissionForm extends AuthRolePermissionFormModel
{
    /**
     * Получает пермишен для роли по ID роли и названию пермишена.
     *
     * @param integer $roleId     идентификатор роли.
     * @param string  $permission имя пермишена.
     *
     * @return AuthRolePermissionActiveRecord|null
     */
    public static function getRolePermissionByIdAndName($roleId, $permission)
    {
        return AuthRolePermissionActiveRecord::findOne([
            'roleId'     => $roleId,
            'permission' => $permission,
        ]);
    }
}
