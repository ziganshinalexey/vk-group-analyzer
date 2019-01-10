<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;

/**
 * Добавляем роль зарегестрированный пользователь всем пользователям.
 */
class m160808_140608_add_users_roles extends AbstractMigration
{
    /**
     * Добавляем роль зарегестрированный пользователь всем пользователям.
     *
     * @return void
     *
     * @throws Exception генерируется в случае неудачной операции.
     */
    public function safeUp()
    {
        $role = Yii::$app->userRole->getRole('registeredUser');
        if (! $role) {
            throw new Exception('Can not find registeredUser role');
        }
        $users = Yii::$app->userProfile->findAll();

        foreach ($users as $user) {
            $model = Yii::$app->userRole->getAssignmentAr();
            $model->setAttributes([
                'roleId'    => $role->id,
                'profileId' => $user->id,
                'isActive'  => 1,
            ]);
            $model->save();
        }
    }

    /**
     * Откат миграции, тут не будет.
     *
     * @return void
     *
     * @throws Exception генерируется в случае неудачной операции.
     */
    public function safeDown()
    {
        $role = Yii::$app->userRole->getRole('registeredUser');
        if (! $role) {
            throw new Exception('Can not find registeredUser role');
        }
        $users = Yii::$app->userProfile->findAll();

        foreach ($users as $user) {
            Yii::$app->userRole->deleteAssignment($user->id, $role->id);
        }
    }
}
