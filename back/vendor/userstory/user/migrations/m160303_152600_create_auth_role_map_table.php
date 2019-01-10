<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\migrations\traits\UserAuthTablesInitTrait;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;

/**
 * Class m160303_152500_authorization_init.
 * Класс миграции, необходим для инициализации авторизации пользователей.
 */
class m160303_152600_create_auth_role_map_table extends AbstractMigration
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
        $this->createTable($this->authRoleMapTable, [
            'id'         => $this->primaryKey(),
            'roleId'     => $this->integer()->notNull(),
            'authSystem' => $this->string(50)->notNull(),
            'roleOuter'  => $this->string(255)->notNull(),
            'creatorId'  => $this->integer(),
            'createDate' => $this->dateTimeWithTZ()->notNull()->defaultExpression('NOW()'),
            'updaterId'  => $this->integer(),
            'updateDate' => $this->dateTimeWithTZ(),
        ], $this->getTableOptions(['COMMENT' => 'Карта полномочии для внешних систем.']));

        // Вторичные ключи auth_role_map
        $fkName = $this->addSuffix($this->authRoleMapTable, '_roleId_fk');
        $this->addForeignKey($fkName, $this->authRoleMapTable, 'roleId', $this->authRoleTable, 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKeyForModifiers($this->authRoleMapTable);
    }

    /**
     * Безопасный метод деинициализации.
     *
     * @return void
     */
    public function safeDown()
    {
        $this->dropTable($this->authRoleMapTable);
    }
}
