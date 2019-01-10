<?php

namespace Userstory\User\models;

use Userstory\User\components\AuthorizationComponent;
use Userstory\User\components\UserRoleComponent;
use Userstory\User\entities\AuthRoleActiveRecord;
use Userstory\User\entities\AuthRolePermissionActiveRecord;
use Userstory\User\traits\FactoryCommonTrait;
use yii;
use yii\base\Model;
use yii\db\Connection;
use yii\db\Exception;

/**
 * Класс формы управления полномочиями роли.
 *
 * @package Userstory\UserAdmin\models
 */
class AuthRolePermissionFormModel extends Model
{
    use FactoryCommonTrait;

    /**
     * Компонент менеджера авторзации.
     *
     * @var AuthorizationComponent|null
     */
    protected $authManager;

    /**
     * Компонент менеджера управления ролями.
     *
     * @var UserRoleComponent|null
     */
    protected $userRoleComponent;

    /**
     * Компонент управления базой данных.
     *
     * @var Connection|null
     */
    protected $dbComponent;

    /**
     * Создаваемая/редактируемая роль.
     *
     * @var AuthRoleActiveRecord|null
     */
    protected $role;

    /**
     * Свойство формы со списком полномочий роли.
     *
     * @var AuthRolePermissionActiveRecord[]
     */
    protected $rolePermissionList = [];

    /**
     * Геттер для получения редактируемой роли.
     *
     * @return AuthRoleActiveRecord
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Геттер для получения списка полномочий роли.
     *
     * @return AuthRolePermissionActiveRecord[]
     */
    public function getRolePermissionList()
    {
        return $this->rolePermissionList;
    }

    /**
     * Геттер для получения компонента авторизации.
     *
     * @return null|AuthorizationComponent
     */
    protected function getAuthManager()
    {
        return $this->authManager;
    }

    /**
     * Сеттер для установки компонента.
     *
     * @param AuthorizationComponent $authManager значение атрибута для установки.
     *
     * @return void
     */
    public function setAuthManager(AuthorizationComponent $authManager)
    {
        $this->authManager = $authManager;
    }

    /**
     * Геттер для получения компонента управления ролями.
     *
     * @return UserRoleComponent значение атрибута для установки.
     */
    protected function getUserRoleComponent()
    {
        return $this->userRoleComponent;
    }

    /**
     * Сеттер для установки компонента управления ролями.
     *
     * @param UserRoleComponent $userRoleComponent значение атрибута для установки.
     *
     * @return void
     */
    public function setUserRoleComponent(UserRoleComponent $userRoleComponent)
    {
        $this->userRoleComponent = $userRoleComponent;
    }

    /**
     * Геттер для компонента управления базой данных.
     *
     * @return null|Connection
     */
    protected function getDbComponent()
    {
        return $this->dbComponent;
    }

    /**
     * Сеттер для установки компонента управления базой данных.
     *
     * @param Connection $dbComponent значение атрибута для установки.
     *
     * @return void
     */
    public function setDbComponent(Connection $dbComponent)
    {
        $this->dbComponent = $dbComponent;
    }

    /**
     * Формирует массив моделей, указанных в входящих данных.
     *
     * @param array       $data     входящие данные.
     * @param null|string $formName наименование формы.
     *
     * @return AuthRolePermissionActiveRecord[]
     */
    public function prepareModelList(array $data, $formName = null)
    {
        $this->rolePermissionList = [];
        $permissionList           = $this->getAuthManager()->permissionsList;
        $prototype                = $this->getUserRoleComponent()->getRolePermissionModel();

        if (null === $formName) {
            $formName = $prototype->formName();
        }

        if ('' === $formName) {
            $arr = $data;
        } elseif (isset($data[$formName]) && is_array($data[$formName]) && ! empty($data[$formName])) {
            $arr = $data[$formName];
        } else {
            return $this->rolePermissionList;
        }

        foreach ($arr as $key => $info) {
            if (isset($info['permission'], $permissionList[$info['permission']])) {
                $this->rolePermissionList[$key] = $this->getUserRoleComponent()->getRolePermissionModel();
            }
        }

        return $this->rolePermissionList;
    }

    /**
     * Установка значений формы из сущности.
     *
     * @param AuthRoleActiveRecord $entity сущность системы.
     *
     * @return static
     */
    public function setEntity(AuthRoleActiveRecord $entity)
    {
        $this->role               = $entity;
        $this->rolePermissionList = $this->role->authRolePermissions;
        return $this;
    }

    /**
     * Загрузка данных сложной формы.
     *
     * @param mixed       $data     данные, полученные от пользователя.
     * @param null|string $formName наименование формы, не используется.
     *
     * @inherit
     *
     * @return boolean
     */
    public function load($data, $formName = null)
    {
        if (empty($data)) {
            return false;
        }

        if (array_key_exists($this->getRole()->formName(), $data)) {
            $r = $this->getRole()->load($data);
        } else {
            $r = $this->getRole()->load(['AuthRoleActiveRecord' => $data]);
        }

        $this->prepareModelList($data);

        return ( empty($this->rolePermissionList) || $this->loadMultiplePermissions($data) ) && $r;
    }

    /**
     * Загрузка данных сложной формы.
     *
     * @param mixed $data данные, полученные от пользователя.
     *
     * @return boolean
     */
    protected function loadMultiplePermissions($data)
    {
        return AuthRolePermissionActiveRecord::loadMultiple($this->rolePermissionList, $data);
    }

    /**
     * Валидация сложноподчиненной формы.
     *
     * @param array|null $attributeNames проверяемые атрибуты формы.
     * @param boolean    $clearErrors    признак предварительной очистки списка ошибок.
     *
     * @return boolean
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        $v = $this->getRole()->validate($attributeNames, $clearErrors);

        foreach ($this->rolePermissionList as $permission) {
            $v = $permission->validate($attributeNames, $clearErrors) && $v;
        }

        return $v;
    }

    /**
     * Сохранение связанных с формой данных.
     *
     * @param boolean $runValidate признак при истинном значении которого происходит предварительная валидация формы.
     *
     * @return false | AuthRoleActiveRecord
     */
    public function save($runValidate = true)
    {
        if ($runValidate && ! $this->validate()) {
            return false;
        }
        $transaction = $this->getDbComponent()->beginTransaction();
        try {
            if ($this->getRole()->save(false)) {
                $existPermission = $this->getRole()->authRolePermissions;
                if (! $this->deletePermission($existPermission, $this->rolePermissionList)) {
                    return false;
                }
                foreach ($this->rolePermissionList as $rolePermission) {
                    if (isset($existPermission[$rolePermission->permission])) {
                        $existPermission[$rolePermission->permission]->isGlobal = $rolePermission->isGlobal;
                        $permission                                             = $existPermission[$rolePermission->permission];
                    } else {
                        $rolePermission->roleId = $this->getRole()->id;
                        $permission             = $rolePermission;
                    }
                    if (! $permission->save(false)) {
                        $rolePermission->addError('permission', 'Во время сохранения полномочия произошла ошибка.');
                        $transaction->rollBack();
                        return false;
                    }
                }
                $transaction->commit();
                return $this->getRole();
            }
            $this->getRole()->addError('name', 'Во время сохранения роли произошла ошибка.');
            $transaction->rollBack();
            return false;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    /**
     * Удаление полномочий, отключенных у роли.
     *
     * @param array|null                       $existPermissionList   список существующих полномочий у роли.
     * @param AuthRolePermissionActiveRecord[] $currentPermissionList список новых полномочий роли.
     *
     * @return boolean
     */
    protected function deletePermission($existPermissionList, array $currentPermissionList)
    {
        if (empty($existPermissionList)) {
            return true;
        }

        $exist   = array_keys($existPermissionList);
        $current = [];

        foreach ($currentPermissionList as $permission) {
            $current[] = $permission->permission;
        }

        if (! empty($deleted = array_diff($exist, $current))) {
            $deleted    = implode(', ', array_map([
                Yii::$app->db,
                'quoteValue',
            ], $deleted));
            $expression = $this->getExpression(sprintf('{{roleId}} = %d AND {{permission}} IN (%s)', $this->getRole()->id, $deleted));
            return (bool)AuthRolePermissionActiveRecord::deleteAll($expression);
        }

        return true;
    }

    /**
     * Метод удаляет роль пользователя.
     *
     * @return boolean
     */
    public function deleteRole()
    {
        return $this->getRole()->delete();
    }
}
