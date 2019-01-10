<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\migrations\traits\UserAuthTablesInitTrait;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;

/**
 * Class m160303_152500_authorization_init.
 * Класс миграции, необходим для инициализации авторизации пользователей.
 */
class m160303_152800_create_auth_role_permission_table extends AbstractMigration
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
     * @throws NotSupportedException Генерируется в родителе в случае, если нет поддержки для текущего типа драйвера.
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authenticationService не существует.
     *
     * @return void
     */
    public function safeUp()
    {
        $this->createTable($this->authRolePermissionTable, [
            'roleId'     => $this->integer(),
            'permission' => $this->string(50)->notNull(),
            'isGlobal'   => $this->smallInteger(1)->notNull()->defaultValue(0),
        ], $this->getTableOptions(['COMMENT' => 'Права с привязкой к роли.']));

        // Основной ключ для прав ролей по связке роль+разрешение
        $this->addPrimaryKey($this->addSuffix($this->authRolePermissionTable, '_pk'), $this->authRolePermissionTable, [
            'roleId',
            'permission',
        ]);

        // Вторичные ключи us_auth_role_permission
        $fkName = $this->addSuffix($this->authRolePermissionTable, '_roleId_fk');
        $this->addForeignKey($fkName, $this->authRolePermissionTable, 'roleId', $this->authRoleTable, 'id', 'CASCADE', 'CASCADE');

        // Добавление к роли администратора полных прав на редактирование пользователя
        $query = $this->getQueryObject();
        $role  = $query->select('id, name')->from($this->authRoleTable)->where(['name' => 'admin'])->one();

        if (is_array($role)) {
            $roleId = $role['id'];
            $this->batchInsert($this->authRolePermissionTable, ['roleId', 'permission', 'isGlobal'], [
                [$roleId, 'User.Admin.Access', 1],
                [$roleId, 'User.Profile.Create', 1],
                [$roleId, 'User.Profile.Read', 1],
                [$roleId, 'User.Profile.Update', 1],
                [$roleId, 'User.Profile.Delete', 1],
            ]);

            if (defined('YII_ENV') && 'dev' === YII_ENV) {
                $this->insert($this->authAssignmentTable, [
                    'roleId'    => $roleId,
                    'profileId' => 1,
                ]);
            }
        }
    }

    /**
     * Безопасный метод деинициализации.
     *
     * @return void
     */
    public function safeDown()
    {
        $this->dropTable($this->authRolePermissionTable);
    }
}
