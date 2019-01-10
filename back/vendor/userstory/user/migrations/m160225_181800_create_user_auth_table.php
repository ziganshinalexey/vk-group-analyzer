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
class m160225_181800_create_user_auth_table extends AbstractMigration
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
        $this->createTable($this->userAuthTable, [
            'id'                 => $this->primaryKey(),
            'authSystem'         => $this->string(50)->notNull()->defaultValue('default'),
            'login'              => $this->string(50)->notNull(),
            'passwordHash'       => $this->string(255)->notNull(),
            'authKey'            => $this->string(32)->notNull(),
            'passwordResetToken' => $this->string()->unique(),
            'creatorId'          => $this->integer(),
            'createDate'         => $this->dateTimeWithTZ()->notNull()->defaultExpression('NOW()'),
            'updaterId'          => $this->integer(),
            'updateDate'         => $this->dateTimeWithTZ(),
            'profileId'          => $this->integer()->notNull(),
        ], $this->getTableOptions(['COMMENT' => 'Таблица авторизации для профиля пользователя']));

        $this->createIndex($this->addSuffix($this->userAuthTable, '_auth_system_login_udx'), $this->userAuthTable, [
            'authSystem',
            'login',
        ], true);

        $this->createIndex($this->addSuffix($this->userAuthTable, '_profile_id_idx'), $this->userAuthTable, 'profileId');

        if (defined('YII_ENV') && 'dev' === YII_ENV) {
            $this->insert($this->userAuthTable, [
                'login'        => 'admin',
                'passwordHash' => Yii::$app->security->generatePasswordHash('123456'),
                'authKey'      => Yii::$app->security->generateRandomString(),
                'profileId'    => 1,
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
        $this->dropTable($this->userAuthTable);
    }
}
