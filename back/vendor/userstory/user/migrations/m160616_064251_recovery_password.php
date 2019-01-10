<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\entities\UserRecoveryActiveRecord;
use Userstory\User\migrations\traits\UserAuthTablesInitTrait;

/**
 * Class m160616_064251_recovery_password.
 * Класс миграции для восстановлении пароля.
 */
class m160616_064251_recovery_password extends AbstractMigration
{
    use UserAuthTablesInitTrait {
        UserAuthTablesInitTrait::init as UserAuthTablesInit;
    }

    /**
     * Название связанного класса.
     *
     * @var string
     */
    protected $relationClass = UserRecoveryActiveRecord::class;

    /**
     * Инициализация класса, получение имен таблиц.
     *
     * @return void
     */
    public function init()
    {
        $this->UserAuthTablesInit();
        parent::init();
    }

    /**
     * Создаем таблицу для восстановления пароля.
     *
     * @return void
     */
    public function safeUp()
    {
        $tableOptions = $this->getTableOptions();
        $this->createTable($this->tableName, [
            'id'         => $this->primaryKey(),
            'profileId'  => $this->integer()->notNull(),
            'code'       => $this->string(32)->notNull(),
            'creatorId'  => $this->integer(),
            'createDate' => $this->dateTimeWithTZ()->notNull()->defaultExpression('NOW()'),
            'updaterId'  => $this->integer(),
            'updateDate' => $this->dateTimeWithTZ(),
        ], $tableOptions);

        $this->addCommentToTable($this->tableName, 'Коды для самостоятельного восстановления пароля.');

        $this->createIndex('recoveryProfileId', $this->tableName, 'profileId', true);

        $suffix = $this->addSuffix($this->tableName, '_profileId_fk');

        $this->addForeignKey($suffix, $this->tableName, 'profileId', $this->userProfileTable, 'id', 'CASCADE', 'CASCADE');

        $this->addForeignKeyForModifiers($this->tableName);
    }

    /**
     * Откат миграции создание таблицы.
     *
     * @return void
     */
    public function safeDown()
    {
        $suffix = $this->addSuffix($this->tableName, '_profileId_fk');
        $this->dropForeignKey($suffix, $this->tableName);
        $this->dropIndex('recoveryProfileId', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
