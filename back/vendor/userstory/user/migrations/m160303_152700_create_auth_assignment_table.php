<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\migrations\traits\UserAuthTablesInitTrait;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;

/**
 * Class m160303_152500_authorization_init.
 * Класс миграции, необходим для инициализации авторизации пользователей.
 */
class m160303_152700_create_auth_assignment_table extends AbstractMigration
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
        $this->createTable($this->authAssignmentTable, [
            'id'         => $this->primaryKey(),
            'roleId'     => $this->integer()->notNull(),
            'profileId'  => $this->integer()->notNull(),
            'isActive'   => $this->smallInteger(1)->notNull()->defaultValue(1),
            'creatorId'  => $this->integer(),
            'createDate' => $this->dateTimeWithTZ()->notNull()->defaultExpression('NOW()'),
            'updaterId'  => $this->integer(),
            'updateDate' => $this->dateTimeWithTZ(),
        ], $this->getTableOptions(['COMMENT' => 'Таблица связки роли и профиля пользователя.']));

        // Вторичные ключи us_auth_assignment
        $fkName = $this->addSuffix($this->authAssignmentTable, '_profileId_fk');
        $this->addForeignKey($fkName, $this->authAssignmentTable, 'profileId', $this->userProfileTable, 'id', 'CASCADE', 'CASCADE');

        $fkName = $this->addSuffix($this->authAssignmentTable, '_roleId_fk');
        $this->addForeignKey($fkName, $this->authAssignmentTable, 'roleId', $this->authRoleTable, 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKeyForModifiers($this->authAssignmentTable);

        // Добавление индекса для сохранения уникальности сочетания роли и профиля.
        $this->createIndex($this->addSuffix($this->authAssignmentTable, '_profileId_roleId_udx'), $this->authAssignmentTable, [
            'profileId',
            'roleId',
        ], true);
    }

    /**
     * Безопасный метод деинициализации.
     *
     * @return void
     */
    public function safeDown()
    {
        $this->dropTable($this->authAssignmentTable);
    }
}
