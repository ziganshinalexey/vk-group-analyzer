<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\migrations\traits\UserAuthTablesInitTrait;

/**
 * Class m170110_035556_add_unregisteredUser_role_permissions.
 * Класс миграции, необходим для добавления разрешений роли неавторизованного пользователя.
 */
class m170110_035556_add_unregisteredUser_role_permissions extends AbstractMigration
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
        $role = $query->select('id, name')->from($this->authRoleTable)->where(['name' => Yii::$app->authManager->guestRole])->one();

        if (! is_array($role)) {
            return;
        }

        $roleId = $role['id'];
        $this->batchInsert($this->authRolePermissionTable, [
            'roleId',
            'permission',
            'isGlobal',
        ], [
            [
                $roleId,
                'User.Profile.Read',
                1,
            ],
            [
                $roleId,
                'User.Profile.Create',
                1,
            ],
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
                'User.Profile.Login',
                1,
            ],
        ]);
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
        $role = $query->select('id, name')->from($this->authRoleTable)->where(['name' => Yii::$app->authManager->guestRole])->one();

        if (! is_array($role)) {
            return;
        }

        $roleId = $role['id'];
        $this->delete($this->authRolePermissionTable, [
            'roleId'     => $roleId,
            'permission' => 'User.Profile.ChangePassword',
        ]);
        $this->delete($this->authRolePermissionTable, [
            'roleId'     => $roleId,
            'permission' => 'User.Profile.SendRecoveryCode',
        ]);
        $this->delete($this->authRolePermissionTable, [
            'roleId'     => $roleId,
            'permission' => 'User.Profile.Login',
        ]);
    }
}
