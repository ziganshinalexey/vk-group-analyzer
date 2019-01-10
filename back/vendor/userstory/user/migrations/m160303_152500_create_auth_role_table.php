<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\migrations\traits\UserAuthTablesInitTrait;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;

/**
 * Class m160303_152500_authorization_init.
 * Класс миграции, необходим для инициализации авторизации пользователей.
 */
class m160303_152500_create_auth_role_table extends AbstractMigration
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
        $this->createTable($this->authRoleTable, [
            'id'          => $this->primaryKey(),
            'name'        => $this->string(50)->notNull()->unique(),
            'description' => $this->text(),
            'canModified' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'creatorId'   => $this->integer(),
            'createDate'  => $this->dateTimeWithTZ()->notNull()->defaultExpression('NOW()'),
            'updaterId'   => $this->integer(),
            'updateDate'  => $this->dateTimeWithTZ(),
        ], $this->getTableOptions(['COMMENT' => 'Таблица ролей пользователей.']));

        // Добавление данных по умолчанию
        $this->insert($this->authRoleTable, [
            'name'        => 'admin',
            'description' => 'Группа администрирования',
            'canModified' => 0,
        ]);
    }

    /**
     * Безопасный метод деинициализации.
     *
     * @return void
     */
    public function safeDown()
    {
        $this->dropTable($this->authRoleTable);
    }
}
