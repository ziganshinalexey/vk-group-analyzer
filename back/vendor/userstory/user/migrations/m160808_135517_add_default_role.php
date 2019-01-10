<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\migrations\traits\UserAuthTablesInitTrait;

/**
 * Класс миграции, необходим для создания роли 'Зарегистрированный пользователь'.
 */
class m160808_135517_add_default_role extends AbstractMigration
{
    use UserAuthTablesInitTrait {
        UserAuthTablesInitTrait::init as private userAuthTablesInitTraitInit;
    }

    /**
     * Безопасная (в транзакции) инициализация.
     *
     * @return void
     *
     * @throws Exception генерируется в случае неудачной операции.
     */
    public function safeUp()
    {
        $role = Yii::$app->userRole->getRole('registeredUser');
        if (null === $role) {
            $data = [
                'name'        => 'registeredUser',
                'description' => 'Зарегистрированный пользователь',
                'canModified' => 0,
            ];
            if (! Yii::$app->userRole->createRole($data)) {
                throw new Exception('Can not create registeredUser role');
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
        $role = Yii::$app->userRole->getRole('registeredUser');
        if (null !== $role) {
            Yii::$app->userRole->deleteRole($role->id);
        }
    }
}
