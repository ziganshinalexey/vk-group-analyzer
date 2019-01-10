<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\migrations\traits\UserAuthTablesInitTrait;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;

/**
 * Class m160225_181700_init.
 * Класс миграции, необходим для инициализации модуля аутентификации пользователей.
 */
class m160225_181700_create_user_profile_table extends AbstractMigration
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
     * Безопасное (в транзакции) создание таблицы пользователей.
     *
     * @throws NotSupportedException Генерируется в родителе в случае, если нет поддержки для текущего типа драйвера.
     * @throws Exception Генерируется, когда что-то пошло не так.
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authenticationService не существует.
     *
     * @return void
     */
    public function safeUp()
    {
        $this->createTable($this->userProfileTable, [
            'id'           => $this->primaryKey(),
            'firstName'    => $this->string(50),
            'lastName'     => $this->string(50),
            'secondName'   => $this->string(50),
            'email'        => $this->string(100),
            'phone'        => $this->bigInteger(),
            'username'     => $this->string(),
            'lastActivity' => $this->dateTimeWithTZ(),
            'isActive'     => $this->smallInteger(1)->notNull()->defaultValue(1),
            'creatorId'    => $this->integer(),
            'createDate'   => $this->dateTimeWithTZ()->notNull()->defaultExpression('NOW()'),
            'updaterId'    => $this->integer(),
            'updateDate'   => $this->dateTimeWithTZ(),
        ], $this->getTableOptions(['COMMENT' => 'Таблица профиля пользователя']));

        $this->addForeignKeyForModifiers($this->userProfileTable);
        $this->addIndex($this->userProfileTable, 'username', false);

        if (defined('YII_ENV') && 'dev' === YII_ENV) {
            $this->insert($this->userProfileTable, [
                'firstName'  => 'Admin',
                'lastName'   => 'Admin',
                'secondName' => 'Admin',
                'email'      => 'dev@dev.userstory.ru',
                'phone'      => 79131234567,
                'username'   => 'admin',
            ]);
        }
    }

    /**
     * Безопасное (в транзакции) удаление таблицы пользователей.
     *
     * @return void
     */
    public function safeDown()
    {
        $this->dropTable($this->userProfileTable);
    }
}
