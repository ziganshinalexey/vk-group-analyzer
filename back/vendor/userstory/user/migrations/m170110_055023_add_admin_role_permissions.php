<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\migrations\traits\UserAuthTablesInitTrait;

/**
 * Class m170110_055023_add_admin_role_permissions.
 * Класс миграции, необходим для добавления разрешений роли администратора.
 */
class m170110_055023_add_admin_role_permissions extends AbstractMigration
{
    use UserAuthTablesInitTrait {
        UserAuthTablesInitTrait::init as private userAuthTablesInitTraitInit;
    }

    /**
     * Инициализация объекта миграции.
     *
     * @return void
     */
    public function init()
    {
        $this->userAuthTablesInitTraitInit();
    }

    /**
     * Безопасная (в транзакции) инициализация.
     *
     * @return void
     */
    public function safeUp()
    {
        $query = $this->getQueryObject();
        /* @var array $role */
        $role = $query->select('id, name')->from($this->authRoleTable)->where(['name' => 'admin'])->one();
        if (is_array($role)) {
            $roleId = $role['id'];
            $this->batchInsert($this->authRolePermissionTable, [
                'roleId',
                'permission',
                'isGlobal',
            ], [
                [
                    $roleId,
                    'User.Profile.ChangePassword',
                    1,
                ],
                [
                    $roleId,
                    'User.Profile.SendRecoveryCode',
                    1,
                ],
                [
                    $roleId,
                    'User.Profile.Logout',
                    1,
                ],
            ]);
        }
    }

    /**
     * Безопасный метод деинициализации.
     *
     * @return void
     */
    public function safeDown()
    {
        $query = $this->getQueryObject();
        /* @var array $role */
        $role = $query->select('id, name')->from($this->authRoleTable)->where(['name' => 'admin'])->one();
        if (is_array($role)) {
            $roleId = $role['id'];
            $this->delete($this->authRolePermissionTable, [
                'roleId'     => $roleId,
                'permission' => 'User.Profile.ChangePassword',
            ]);
            $this->delete($this->authRolePermissionTable, [
                'roleId'     => $roleId,
                'permission' => 'User.Profile.SendRecoveryCode',
            ]);
        }
    }
}
