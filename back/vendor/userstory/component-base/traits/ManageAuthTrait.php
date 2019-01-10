<?php

namespace Userstory\ComponentBase\traits;

use Userstory\ModuleUser\components\AuthorizationComponent;
use yii;
use yii\base\InvalidConfigException;
use yii\db\Query;

/**
 * Trait InsertAuthTrait.
 * Трейт для общих операций в миграциях добавления прав доступа.
 *
 * @package app\migrations
 */
trait ManageAuthTrait
{
    /**
     * Разрешения для авторизации в модуле.
     * Разрешения должны быть заданы как $permissionName => [0|1|true|false].
     *
     * @var array
     */
    protected $permissions = [];

    /**
     * Роль связанная с разрешениями.
     *
     * @var string
     */
    protected $roleName = 'admin';

    /**
     * Получение сервиса авторизации.
     *
     * @throws InvalidConfigException Возможное исключение при неправильной настройке менеджера авторизации.
     *
     * @return AuthorizationComponent
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
     * Метод возвращает идентификатор для заданной роли.
     *
     * @param string $roleName Название роли.
     *
     * @throws InvalidConfigException Возможное исключение при неправильной настройке менеджера авторизации.
     *
     * @todo избавиться от запроса к чужой модели
     *
     * @return integer
     */
    protected function getRoleId($roleName = null)
    {
        if (null === $roleName) {
            $roleName = $this->roleName;
        }

        return (new Query())->select('id')->from($this->getAuthManager()->authRole)->where(['name' => $roleName])->scalar();
    }

    /**
     * Метод возвращает идентификатор для заданной роли.
     *
     * @param string $roleName Название роли.
     *
     * @throws InvalidConfigException Возможное исключение при неправильной настройке менеджера авторизации.
     *
     * @todo избавиться от запроса к чужой модели
     *
     * @return boolean
     */
    public function hasRole($roleName = null)
    {
        if (null === $roleName) {
            $roleName = $this->roleName;
        }

        return (new Query())->from($this->getAuthManager()->authRole)->where(['name' => $roleName])->exists();
    }

    /**
     * Метод добавляет авторизационные данные (разрешения) для текущей заданной роли.
     *
     * @param string $roleName    Название роли.
     * @param array  $permissions Список разрешений роли.
     *
     * @throws InvalidConfigException Возможное исключение при неправильной настройке менеджера авторизации.
     *
     * @return void
     */
    protected function insertAuth($roleName = null, array $permissions = [])
    {
        if (empty($permissions)) {
            $permissions = $this->permissions;
        }

        if (! $this->hasRole($roleName)) {
            return;
        }

        $roleId     = $this->getRoleId($roleName);
        $insertData = [];

        foreach ($permissions as $permission => $isGlobal) {
            $insertData[] = [
                'roleId'     => $roleId,
                'permission' => $permission,
                'isGlobal'   => (int)$isGlobal,
            ];
        }

        $this->batchInsert($this->getAuthManager()->authRolePermission, [
            'roleId',
            'permission',
            'isGlobal',
        ], $insertData);
    }

    /**
     * Метод удаляет добавленные разрешения для текущей роли.
     *
     * @param string $roleName    Название роли.
     * @param array  $permissions Список разрешений роли.
     *
     * @throws InvalidConfigException Возможное исключение при неправильной настройке менеджера авторизации.
     *
     * @return void
     */
    protected function removeAuth($roleName = null, array $permissions = [])
    {
        if (empty($permissions)) {
            $permissions = $this->permissions;
        }

        if (! $this->hasRole($roleName)) {
            return;
        }

        $this->delete($this->getAuthManager()->authRolePermission, [
            'permission' => array_keys($permissions),
            'roleId'     => $this->getRoleId($roleName),
        ]);
    }

    /**
     * Метод добавляет новую роль.
     *
     * @param array $config Массив с конфигурацией новой роли.
     *
     * @throws InvalidConfigException Возможное исключение при неправильной настройке менеджера авторизации.
     *
     * @return void
     */
    protected function insertRole(array $config = [])
    {
        if (0 !== count($config)) {
            $this->insert($this->getAuthManager()->authRole, $config);
        }
    }

    /**
     * Метод удаляет заданную в конфигурации роль.
     *
     * @param array $config Массив с конфигурацией роли.
     *
     * @throws InvalidConfigException Возможное исключение при неправильной настройке менеджера авторизации.
     *
     * @return void
     */
    protected function removeRole(array $config = [])
    {
        if (0 !== count($config)) {
            $this->delete($this->getAuthManager()->authRole, $config);
        }
    }
}
