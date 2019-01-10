<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\migrations\traits\UserAuthTablesInitTrait;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;

/**
 * Class m160331_171200_profile_setting
 * Миграция создающаяя таблицу настроек пользователя.
 */
class m160331_171201_create_profile_setting extends AbstractMigration
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
        $this->createTable($this->userProfileSettingsTable, [
            'fieldsetPk' => $this->primaryKey(),
            'relationId' => $this->integer()->notNull(),
            'fieldsetId' => $this->integer()->notNull(),
            'dataJson'   => 'JSON NOT NULL',
            'creatorId'  => $this->integer(),
            'createDate' => $this->dateTimeWithTZ()->notNull()->defaultExpression('NOW()'),
            'updaterId'  => $this->integer(),
            'updateDate' => $this->dateTimeWithTZ(),
        ], $this->getTableOptions(['COMMENT' => 'Таблица настроек профиля пользователя.']));

        $fkName = $this->addSuffix($this->userProfileSettingsTable, '_relationId_fk');
        $this->addForeignKey($fkName, $this->userProfileSettingsTable, ['relationId'], '{{%profile}}', ['id'], 'CASCADE', 'CASCADE');

        $fkName = $this->addSuffix($this->userProfileSettingsTable, '_fieldsetId_fk');
        $this->addForeignKey($fkName, $this->userProfileSettingsTable, ['fieldsetId'], $this->fieldsetTable, ['id'], 'CASCADE', 'CASCADE');

        $this->addForeignKeyForModifiers($this->userProfileSettingsTable);
    }

    /**
     * Безопасный метод деинициализации.
     *
     * @return void
     */
    public function safeDown()
    {
        $this->dropTable($this->userProfileSettingsTable);
    }
}
