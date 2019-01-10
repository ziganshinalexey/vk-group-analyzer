<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\migrations\traits\UserAuthTablesInitTrait;

/**
 * Class m170110_035020_add_unauthorizedUser_role.
 * Класс миграции, необходим для добавления роли неавторизованного пользователя.
 */
class m170110_035020_add_unauthorizedUser_role extends AbstractMigration
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
     * @return void
     */
    public function safeUp()
    {
        $role = Yii::$app->userRole->getRole(Yii::$app->authManager->guestRole);
        if (null === $role) {
            $this->insert($this->authRoleTable, [
                'name'        => Yii::$app->authManager->guestRole,
                'description' => 'Гость',
                'canModified' => 0,
            ]);
        }
    }

    /**
     * Безопасный метод деинициализации.
     *
     * @return void
     */
    public function safeDown()
    {
        $this->delete($this->authRoleTable, ['name' => Yii::$app->authManager->guestRole]);
    }
}
