<?php

namespace Userstory\User\components;

use Userstory\User\entities\AuthRoleActiveRecord;
use yii;
use yii\base\Component;
use yii\caching\Cache;

/**
 * Класс UserRoleCacheComponent.
 * Кэш ролей профилей пользователя в меемкеше.
 *
 * @package Userstory\User\components
 */
class UserRoleCacheComponent extends Component
{
    const USER_ROLE_CACHE_SALT             = 'user_role';
    const ROLE_ASSIGNMENT_EXIST_CACHE_SALT = 'user_role_assignment_exist_role';
    const ROLE_ASSIGNMENT_EXIST            = 'exist';
    const ROLE_ASSIGNMENT_NOT_EXIST        = 'not_exist';

    /**
     * Компонент, через который кладем или получаем данные.
     *
     * @var Cache|null
     */
    protected $cache;

    /**
     * Параметр, определяющий обязательность кэширования.
     *
     * @var boolean
     */
    protected $required = false;

    /**
     * Метод устанавливает значение параметра required.
     *
     * @param boolean $required Параметр, определяющий обязательность кэширования.
     *
     * @return void
     */
    public function setRequired($required)
    {
        $this->required = $required;
    }

    /**
     * Метод получает компонент, через который работаем с подсистемой кеша.
     *
     * @return Cache
     */
    protected function getCache()
    {
        if (! $this->cache) {
            $this->cache = Yii::$app->cache;
        }

        return $this->cache;
    }

    /**
     * Метод возвращает роль по имени.
     *
     * @param string $name Название роли.
     *
     * @return AuthRoleActiveRecord|null
     */
    public function getRoleByName($name)
    {
        $key    = static::USER_ROLE_CACHE_SALT . $name;
        $result = $this->getCache()->get($key);
        if (! $result) {
            return null;
        }
        return $result;
    }

    /**
     * Проверить, присвоена ли роль пользователю.
     *
     * @param integer $profileId идентификатор профиля.
     * @param integer $roleId    идентификатор роли.
     *
     * @return boolean|null
     */
    public function assignmentIsExist($profileId, $roleId)
    {
        $key    = static::ROLE_ASSIGNMENT_EXIST_CACHE_SALT . $profileId . '_' . $roleId;
        $result = $this->getCache()->get($key);
        if (false === $result) {
            return null;
        }
        if (static::ROLE_ASSIGNMENT_EXIST === $result) {
            return true;
        }
        return false;
    }

    /**
     * Проверить, присвоена ли роль пользователю.
     *
     * @param integer $profileId идентификатор профиля.
     * @param integer $roleId    идентификатор роли.
     * @param boolean $isExist   существует ли роль.
     *
     * @return boolean
     */
    public function setAssignmentExist($profileId, $roleId, $isExist)
    {
        $key = static::ROLE_ASSIGNMENT_EXIST_CACHE_SALT . $profileId . '_' . $roleId;
        if (true === $isExist) {
            return $this->getCache()->set($key, static::ROLE_ASSIGNMENT_EXIST);
        }
        return $this->getCache()->set($key, static::ROLE_ASSIGNMENT_NOT_EXIST);
    }

    /**
     * Метод кладет роль пользователя в кэш.
     *
     * @param string               $name Название роли.
     * @param AuthRoleActiveRecord $role Роль пользователя.
     *
     * @return boolean
     */
    public function setRoleByName($name, AuthRoleActiveRecord $role)
    {
        $key = static::USER_ROLE_CACHE_SALT . $name;
        return $this->getCache()->set($key, $role);
    }

    /**
     * Метод удаляет роль пользователя из кэша.
     *
     * @param integer $profileId идентификатор профиля.
     * @param integer $roleId    идентификатор роли.
     *
     * @return void
     */
    public function deleteAssignmentExist($profileId, $roleId)
    {
        $key = static::ROLE_ASSIGNMENT_EXIST_CACHE_SALT . $profileId . '_' . $roleId;
        $this->getCache()->delete($key);
    }

    /**
     * Метод удаляет роль пользователя из кэша.
     *
     * @param string $name Название роли.
     *
     * @return void
     */
    public function deleteRole($name)
    {
        $key = static::USER_ROLE_CACHE_SALT . $name;
        $this->getCache()->delete($key);
    }
}
