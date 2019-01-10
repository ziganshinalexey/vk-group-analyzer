<?php

namespace Userstory\UserAdmin\factories;

use Userstory\ComponentBase\models\ModelsFactory as BaseFactory;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\UserAdmin\forms\LoginForm;
use Userstory\UserAdmin\forms\PermissionForm;
use Userstory\UserAdmin\forms\RecoveryForm;
use Userstory\UserAdmin\forms\RoleForm;
use Userstory\UserAdmin\forms\UserProfileForm;
use Userstory\UserAdmin\operations\CommonOperation;
use Userstory\UserAdmin\operations\NotifyOperation;
use yii;
use yii\data\DataProviderInterface;

/**
 * Class UserAdminFactory.
 * Класс фабрики для создания объектов.
 *
 * @package Userstory\UserAdmin\factories
 */
class UserAdminFactory extends BaseFactory
{
    /**
     * Метод возвращает объект формы логина.
     *
     * @param array $config Конфигурация для работы.
     *
     * @return LoginForm
     */
    public function getLoginForm(array $config = [])
    {
        $config = ArrayHelper::merge($config, ['ip' => Yii::$app->request->getUserIP()]);
        return $this->getModelInstance('loginForm', $config, false);
    }

    /**
     * Метод возвращает объект формы восстановления доступа.
     *
     * @param array $config Конфигурация для работы.
     *
     * @return RecoveryForm
     */
    public function getRecoveryForm(array $config = [])
    {
        return $this->getModelInstance('recoveryForm', $config, false);
    }

    /**
     * Метод возвращает объект операций для работы с уведомлениями.
     *
     * @param array $config Конфигурация для работы.
     *
     * @return NotifyOperation
     */
    public function getNotifyOperation(array $config = [])
    {
        return $this->getModelInstance('notifyOperation', $config, false);
    }

    /**
     * Метод возвращает объект общих операций.
     *
     * @param array $config Конфигурация для работы.
     *
     * @return CommonOperation
     */
    public function getCommonOperation(array $config = [])
    {
        return $this->getModelInstance('commonOperation', $config, false);
    }

    /**
     * Метод возвращает объект формы для работы с ролями.
     *
     * @param array $config Конфигурация для работы.
     *
     * @return RoleForm
     */
    public function getRoleForm(array $config = [])
    {
        return $this->getModelInstance('roleForm', $config, false);
    }

    /**
     * Метод возвращает объект формы для работы с разрешениями.
     *
     * @param array $config Конфигурация для работы.
     *
     * @return PermissionForm
     */
    public function getPermissionForm(array $config = [])
    {
        return $this->getModelInstance('permissionForm', $config, false);
    }

    /**
     * Метод возвращает объект формы создания/редактирования профиля пользователя.
     *
     * @param array $config Конфигурация для работы.
     *
     * @return UserProfileForm
     */
    public function getUserProfileForm(array $config = [])
    {
        return $this->getModelInstance('userProfileForm', $config, false);
    }

    /**
     * Метод возвращает объект провайдера данных.
     *
     * @param array $config Конфигурация для работы.
     *
     * @return DataProviderInterface
     */
    public function getDataProvider(array $config = [])
    {
        return $this->getModelInstance('dataProvider', $config, false);
    }
}
