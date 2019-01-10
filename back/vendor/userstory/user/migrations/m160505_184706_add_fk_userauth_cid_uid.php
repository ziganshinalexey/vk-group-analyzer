<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\migrations\traits\UserAuthTablesInitTrait;
use yii\base\InvalidConfigException;

/**
 * Class m160505_184706_add_fk_userauth_cid_uid
 * Миграция для добавления внешнего ключа к таблице анутификации.
 */
class m160505_184706_add_fk_userauth_cid_uid extends AbstractMigration
{
    use UserAuthTablesInitTrait {
        UserAuthTablesInitTrait::init as private userAuthInitTable;
    }

    /**
     * Перегрузка метода инициализации.
     *
     * @return void
     */
    public function init()
    {
        $this->userAuthInitTable();
    }

    /**
     * Безопасное (в транзакции) добавление внешего ключа.
     *
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authenticationService не существует.
     *
     * @return void
     */
    public function safeUp()
    {
        $this->addForeignKeyForModifiers($this->userAuthTable);
    }

    /**
     * Безопасное (в транзакции) удаление внешего ключа.
     *
     * @return void
     */
    public function safeDown()
    {
        $this->dropForeignKeyForModifiers($this->userAuthTable);
    }
}
