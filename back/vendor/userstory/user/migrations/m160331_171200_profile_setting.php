<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\migrations\traits\UserAuthTablesInitTrait;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;

/**
 * Class m160331_171200_profile_setting
 * Миграция создающаяя дополнительные поля для пользователя.
 */
class m160331_171200_profile_setting extends AbstractMigration
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
        $this->insert($this->fieldsetTable, [
            'name'        => 'profile_setting',
            'caption'     => 'Дополнительные свойства профиля пользователя',
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
        $this->delete($this->fieldsetTable, ['name' => 'profile_setting']);
    }
}
