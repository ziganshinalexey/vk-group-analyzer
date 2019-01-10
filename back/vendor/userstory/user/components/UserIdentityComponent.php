<?php

namespace Userstory\User\components;

use Userstory\User\entities\UserAuthActiveRecord;
use yii;
use yii\base\InvalidParamException;
use yii\base\InvalidValueException;
use yii\web\IdentityInterface;
use yii\web\User as YiiUser;

/**
 * Class UserIdentityComponent.
 * Класс переопределяет поведение метода can, т.к. необходимо проверяет полномочия у профиля пользователя.
 *
 * @method UserAuthActiveRecord getIdentity( $autoRenew = true )
 *
 * @package Userstory\User\components
 */
class UserIdentityComponent extends YiiUser
{
    /**
     * Локальный кэш найденных полномочий.
     *
     * @var array
     */
    protected $accessList = [];

    /**
     * Перегруженный метод, для обнуления локального кэша полномочий.
     *
     * @param null|IdentityInterface $identity пользователь, прошедший аутентификацию.
     *
     * @return void
     * @throws InvalidValueException переданный объект не реализует IdentityInterface.
     */
    public function setIdentity($identity)
    {
        parent::setIdentity($identity);

        if ($identity instanceof IdentityInterface) {
            $this->accessList = [];
        }
    }

    /**
     * Метод проверяет наличие полномочий у пользователя, прошедшего аутентификацию.
     *
     * @param string|mixed $permissionName проверяемое полномочие.
     * @param mixed        $params         контекст проверяемого полномочия.
     * @param boolean      $allowCaching   позвлять сохранять результат проверки в памяти.
     *
     * @throws InvalidParamException если пермишена не существует.
     *
     * @return boolean
     */
    public function can($permissionName, $params = [], $allowCaching = true)
    {
        if ($allowCaching && empty( $params ) && isset( $this->accessList[$permissionName] )) {
            return $this->accessList[$permissionName];
        }

        if (! $this->getIdentity() || null === ( $manager = $this->getAccessChecker() )) {
            return false;
        }

        $access = $manager->checkAccess($this->getIdentity()->profileId, $permissionName, $params);
        if ($allowCaching && empty( $params )) {
            $this->accessList[$permissionName] = $access;
        }

        return $access;
    }

    /**
     * Проверяет, обладает ли пользователь указанным полномочием.
     *
     * @param string $needle полномочие или его часть.
     *
     * @return boolean
     */
    public function hasPermission($needle)
    {
        $profileId = $this->getIdentity()->profileId;

        if (($manager = $this->getAuthManager()) === null) {
            return false;
        }

        $permissions = $manager->getPermissionsByUser($profileId);

        foreach ($permissions as $key => $item) {
            if (stristr($key, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Проверка является ли пользователем админом.
     *
     * @return boolean
     */
    public function isAdmin()
    {
        /* @var UserRoleComponent $roleComponent */
        $roleComponent = Yii::$app->userRole;
        $roleId        = $roleComponent->findByName('admin')->id;
        $isAdmin       = $roleComponent->findAssignByRoleAndProfile($roleId, $this->getIdentity()->profileId);

        return (bool)$isAdmin;
    }
}
