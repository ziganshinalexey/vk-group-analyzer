<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\User\components\AuthorizationComponent;
use yii\base\InvalidConfigException;

/**
 * Class m170807_054530_add_permission_list_profile.
 * Добавляем к роли админу доступ на получение списка пользователей.
 */
class m170807_054530_add_permission_list_profile extends AbstractMigration
{
    /**
     * Получение сервиса авторизации.
     *
     * @return AuthorizationComponent
     *
     * @throws InvalidConfigException исключение, возникающее если не настроен "AuthManager".
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (! $authManager instanceof AuthorizationComponent) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }

    /**
     * Безопасная (в транзакции) инициализация.
     *
     * @return void
     */
    public function safeUp()
    {
        $authManager = $this->getAuthManager();

        // Определение прав доступа в публичной части.
        $role = Yii::$app->userRole->getRole('admin');
        if ($role) {
            $roleId = $role->id;
            $this->batchInsert($authManager->authRolePermission, [
                'roleId',
                'permission',
                'isGlobal',
            ], [
                [
                    $roleId,
                    'User.Profile.List',
                    0,
                ],
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
        $authManager = $this->getAuthManager();
        $this->delete($authManager->authRolePermission, [
            'in',
            'permission',
            ['User.Profile.List'],
        ]);
    }
}
