<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\migrations\traits\UserAuthTablesInitTrait;
use yii\base\InvalidConfigException;

/**
 * Class m160424_141120_auth_role_create_roles
 * Миграция добавляющая разрашения для управления ролями в группу администраторов.
 */
class m160424_141120_auth_role_create_roles extends AbstractMigration
{
    use UserAuthTablesInitTrait;

    /**
     * Безопасная (в транзакции) инициализация.
     *
     * @return void
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authenticationService не существует.
     */
    public function safeUp()
    {
        $query = $this->getQueryObject();
        /* @var $row array */
        $row = $query->select('id')->from($this->authRoleTable)->where(['name' => 'admin'])->one();

        $adminId = $row['id'];

        $columns = [
            'roleId',
            'permission',
            'isGlobal',
        ];
        $this->batchInsert($this->authRolePermissionTable, $columns, [
            [
                $adminId,
                'User.Role.Read',
                1,
            ],
            [
                $adminId,
                'User.Role.Create',
                1,
            ],
            [
                $adminId,
                'User.Role.Update',
                1,
            ],
            [
                $adminId,
                'User.Role.Delete',
                1,
            ],

            [
                $adminId,
                'User.RoleAssignment.Read',
                1,
            ],
            [
                $adminId,
                'User.RoleAssignment.Create',
                1,
            ],
            [
                $adminId,
                'User.RoleAssignment.Update',
                1,
            ],
            [
                $adminId,
                'User.RoleAssignment.Delete',
                1,
            ],

            [
                $adminId,
                'User.RolePermission.Read',
                1,
            ],
            [
                $adminId,
                'User.RolePermission.Create',
                1,
            ],
            [
                $adminId,
                'User.RolePermission.Update',
                1,
            ],
            [
                $adminId,
                'User.RolePermission.Delete',
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
        $this->delete($this->authRolePermissionTable, [
            'LIKE',
            'permission',
            'User.RolePermission.%',
            false,
        ]);
        $this->delete($this->authRolePermissionTable, [
            'LIKE',
            'permission',
            'User.RoleAssignment.%',
            false,
        ]);
        $this->delete($this->authRolePermissionTable, [
            'LIKE',
            'permission',
            'User.Role.%',
            false,
        ]);
    }
}
