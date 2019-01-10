<?php

namespace Userstory\User\components;

use Exception;
use Userstory\User\entities\AuthAssignmentActiveRecord;
use Userstory\User\entities\AuthRoleActiveRecord;
use Userstory\User\models\AuthRolePermissionFormModel;
use Userstory\User\operations\AssignmentDeleteOperation;
use Userstory\User\operations\AssignmentGetOperation;
use Userstory\User\operations\AssignmentSaveOperation;
use Userstory\User\queries\AuthAssignmentQuery;
use Userstory\User\queries\AuthRoleQuery;
use Userstory\User\queries\RolePermissionQuery;
use yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;

/**
 * Публичный кКомпонент для управления сущностями "Роли" и Полномочия.
 *
 * @property RolePermissionQuery $rolePermissionQuery
 *
 * @package Userstory\User\components
 */
class UserRoleComponent extends Component
{
    const USER_ROLE_KEY             = 'authRoleAR';
    const USER_ROLE_PERMISSION_KEY  = 'authRolePermission';
    const USER_ROLE_QUERY_KEY       = 'authRoleQuery';
    const ROLE_PERMISSION_QUERY_KEY = 'rolePermissionQuery';
    const ROLE_PERMISSION_SAVER_KEY = 'rolePermissionSaver';
    const ROLE_PROVIDER_KEY         = 'authRoleDataProvider';
    const ROLE_FORM_KEY             = 'authRoleForm';
    const ASSIGNMENT_QUERY_KEY      = 'authAssignmentQuery';
    const ASSIGNMENT_KEY            = 'authAssignmentAR';

    /**
     * Все ошибки после валидации моделей.
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Список моделей, с которыми работает текущий компонент.
     *
     * @var array
     */
    protected $modelClasses = [];

    /**
     * Кешируем Уже созданные объекты.
     *
     * @var array
     */
    protected $instances = [];

    /**
     * Получаем объект модели роли пользователя.
     *
     * @return mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    protected function getRoleModel()
    {
        return Yii::createObject($this->modelClasses[self::USER_ROLE_KEY]);
    }

    /**
     * Получаем объект модели для назначения полномочий ролям.
     *
     * @return mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    protected function getRolePermissionSaver()
    {
        return Yii::createObject([
            'class'       => $this->modelClasses[self::ROLE_PERMISSION_SAVER_KEY],
            'dbComponent' => Yii::$app->get('db'),
        ]);
    }

    /**
     * Получаем объект модели роли пользователя.
     *
     * @return mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getRolePermissionModel()
    {
        return Yii::createObject($this->modelClasses[self::USER_ROLE_PERMISSION_KEY]);
    }

    /**
     * Получаем объект построителя запросов для модели роли пользователя.
     *
     * @return AuthRoleQuery|mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-запроса.
     */
    protected function getUserRoleQuery()
    {
        return Yii::createObject($this->modelClasses[self::USER_ROLE_QUERY_KEY], [$this->modelClasses[self::USER_ROLE_KEY]]);
    }

    /**
     * Получаем объект построителя запросов для модели роли пользователя.
     *
     * @return mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-запроса.
     */
    protected function getRolePermissionQuery()
    {
        $modelClass = $this->modelClasses[self::USER_ROLE_PERMISSION_KEY];
        return Yii::createObject($this->modelClasses[self::ROLE_PERMISSION_QUERY_KEY], [$modelClass]);
    }

    /**
     * Получаем объект построителя запросов для модели назначения роли пользователя.
     *
     * @return AuthAssignmentQuery|mixed
     */
    protected function getAssignmentQuery()
    {
        $modelClass = $this->modelClasses[self::ASSIGNMENT_KEY];
        return Yii::createObject($this->modelClasses[self::ASSIGNMENT_QUERY_KEY], [$modelClass]);
    }

    /**
     * Метод устанаваливает пермишены на роль.
     *
     * @param integer $roleId         ИД роли для установки.
     * @param array   $permissionList Список пермишенов для установки.
     *
     * @return boolean
     */
    public function setPermissionOnRole($roleId, array $permissionList)
    {
        $saver         = $this->getRolePermissionSaver();
        $authRoleModel = $this->findById($roleId);
        if (! $authRoleModel) {
            return false;
        }
        $saver->authRoleModel = $authRoleModel;
        return $saver->setPermissionOnRole($permissionList);
    }

    /**
     * Метод удаляет пермишены на роль.
     *
     * @param integer $roleId         ИД роли для установки.
     * @param array   $permissionList Список пермишенов для установки.
     *
     * @return boolean
     */
    public function deletePermission($roleId, array $permissionList)
    {
        $saver         = $this->getRolePermissionSaver();
        $authRoleModel = $this->findById($roleId);
        if (! $authRoleModel) {
            return false;
        }
        $saver->authRoleModel = $authRoleModel;
        return $saver->deletePermission($permissionList);
    }

    /**
     * Получить объект формы роли.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     *
     * @return AuthRolePermissionFormModel
     */
    public function getRoleForm()
    {
        /* @var AuthRolePermissionFormModel $form */
        $form = Yii::createObject([
            'class'             => $this->modelClasses[self::ROLE_FORM_KEY],
            'authManager'       => Yii::$app->authManager,
            'dbComponent'       => Yii::$app->get('db'),
            'userRoleComponent' => $this,
        ]);

        $form->setEntity($this->getRoleModel());

        return $form;
    }

    /**
     * Получить объект провайдера роли.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     *
     * @return ActiveDataProvider
     */
    public function getRoleDataProvider()
    {
        /* @var ActiveDataProvider $provider */
        $provider = Yii::createObject([
            'class' => $this->modelClasses[self::ROLE_PROVIDER_KEY],
            'query' => $this->getUserRoleQuery(),
        ]);

        return $provider;
    }

    /**
     * Находим интересующию роль по ID.
     *
     * @param integer $roleId Идентификатор интересующего профиля пользователя.
     *
     * @return AuthRoleActiveRecord|mixed
     */
    public function findById($roleId)
    {
        return $this->getUserRoleQuery()->byId($roleId)->one();
    }

    /**
     * Находим интересующию роль по имени.
     *
     * @param string $name Имя роли для поиска.
     *
     * @return AuthRoleActiveRecord|mixed
     */
    public function findByName($name)
    {
        return $this->getUserRoleQuery()->byName($name)->one();
    }

    /**
     * Получить объект роли по названию.
     *
     * @param array $roleData Данные для сохранения роли.
     *
     * @return false | AuthRoleActiveRecord
     */
    public function createRole(array $roleData)
    {
        /* @var AuthRolePermissionFormModel $roleSaver */
        $roleSaver = $this->getRoleForm();
        $roleSaver->setEntity($this->getRoleModel());

        return $this->saveRole($roleSaver, $roleData);
    }

    /**
     * Получить объект роли по названию.
     *
     * @param integer $id       Данные для сохранения роли.
     * @param array   $roleData Данные для сохранения роли.
     *
     * @return false | AuthRoleActiveRecord
     */
    public function updateRole($id, array $roleData)
    {
        /* @var AuthRolePermissionFormModel $roleSaver */
        $roleSaver = $this->getRoleForm();
        $roleSaver->setEntity($this->findById($id));

        return $this->saveRole($roleSaver, $roleData);
    }

    /**
     * Метод удаляет объект роли.
     *
     * @param integer $id Данные для сохранения роли.
     *
     * @return boolean
     */
    public function deleteRole($id)
    {
        /* @var AuthRolePermissionFormModel $roleSaver */
        $roleSaver = $this->getRoleForm();
        $entity    = $this->findById($id);

        if (! $entity) {
            return true;
        }

        return $roleSaver->setEntity($entity)->deleteRole();
    }

    /**
     * Метод выполняет действия для сохранения роли пользователя.
     *
     * @param AuthRolePermissionFormModel $roleSaver Объект сохранятель роли.
     * @param array                       $roleData  Данные для сохранения роли.
     *
     * @return false | AuthRoleActiveRecord
     * @throws Exception Исключение генерируется в случае проблемм с транзакциями.
     */
    protected function saveRole(AuthRolePermissionFormModel $roleSaver, array $roleData)
    {
        $roleSaver->load($roleData);
        return $roleSaver->save();
    }

    /**
     * Получить объект роли по названию.
     *
     * @param string $name название роли.
     *
     * @return AuthRoleActiveRecord
     */
    public function getRole($name)
    {
        /* @var UserRoleCacheComponent $cacheComponent */
        $cacheComponent = Yii::$app->userRoleCache;
        $role           = $cacheComponent->getRoleByName($name);

        if (null === $role) {
            /* @var  AuthRoleQuery $query */
            $query = Yii::createObject($this->modelClasses['authRoleQuery'], [$this->modelClasses['authRoleAR']]);
            $role  = $query->byName($name)->one();
            if (null !== $role) {
                $cacheComponent->setRoleByName($name, $role);
            }
        }

        return $role;
    }

    /**
     * Удалить присвоенную роль пользователю.
     *
     * @param integer $profileId идентификатор профиля.
     * @param integer $roleId    идентификатор роли.
     *
     * @return boolean
     */
    public function deleteAssignment($profileId, $roleId)
    {
        $deleter = $this->getAssignmentDeleter();
        $deleter->setAssignmentAr($this->getAssignmentGetter()->getByUserRole($profileId, $roleId));
        /* @var UserRoleCacheComponent $cacheComponent */
        $cacheComponent = Yii::$app->userRoleCache;
        $cacheComponent->deleteAssignmentExist($profileId, $roleId);

        return $deleter->delete();
    }

    /**
     * Метод для присвоения роли пользователю.
     *
     * @param array $data массив атрибутов для сохранения.
     *
     * @return null|AuthAssignmentActiveRecord
     */
    public function createAssignment(array $data)
    {
        $saver = $this->getAssignmentSaver();
        $saver->setAssignmentAr($this->getAssignmentAr());

        if ($saver->load($data) && null !== $model = $saver->save()) {
            return $model;
        }

        $this->errors = $saver->errors;

        return null;
    }

    /**
     * Проверить, присвоена ли роль пользователю.
     *
     * @param integer $profileId идентификатор профиля.
     * @param integer $roleId    идентификатор роли.
     *
     * @return boolean
     */
    public function assignmentIsExist($profileId, $roleId)
    {
        /* @var UserRoleCacheComponent $cacheComponent */
        $cacheComponent = Yii::$app->userRoleCache;
        $isExist        = $cacheComponent->assignmentIsExist($profileId, $roleId);

        if (null === $isExist) {
            $isExist = $this->getAssignmentGetter()->isExist($profileId, $roleId);
            $cacheComponent->setAssignmentExist($profileId, $roleId, $isExist);
        }

        return $isExist;
    }

    /**
     * Получить объект сущности полномочия.
     *
     * @param boolean $new флаг, определяющий, нужно ли создавать новый объект.
     *
     * @return AuthAssignmentActiveRecord
     */
    public function getAssignmentAr($new = true)
    {
        if (! isset($this->instances['assignmentAr']) || $new) {
            $this->instances['assignmentAr'] = Yii::createObject($this->modelClasses['authAssignmentAR']);
        }

        return $this->instances['assignmentAr'];
    }

    /**
     * Получить объект класса для сохранения полномочия.
     *
     * @param boolean $new флаг, определяющий, нужно ли создавать новый объект.
     *
     * @return AssignmentSaveOperation
     */
    public function getAssignmentSaver($new = true)
    {
        if (! isset($this->instances['assignmentSaveOperation']) || $new) {
            $this->instances['assignmentSaveOperation'] = Yii::createObject($this->modelClasses['assignmentSaveOperation']);
        }

        return $this->instances['assignmentSaveOperation'];
    }

    /**
     * Получить объект класса для удаления полномочий.
     *
     * @param boolean $new флаг, определяющий, нужно ли создавать новый объект.
     *
     * @return AssignmentDeleteOperation
     */
    public function getAssignmentDeleter($new = true)
    {
        if (! isset($this->instances['assignmentDeleteOperation']) || $new) {
            $this->instances['assignmentDeleteOperation'] = Yii::createObject($this->modelClasses['assignmentDeleteOperation']);
        }

        return $this->instances['assignmentDeleteOperation'];
    }

    /**
     * Получить объект геттера полномочий.
     *
     * @param boolean $new флаг, определяющий, нужно ли создавать новый объект.
     *
     * @throws InvalidConfigException Исключение генерируется во внутренних вызовах.
     *
     * @return AssignmentGetOperation
     */
    public function getAssignmentGetter($new = true)
    {
        if (! isset($this->instances['assignmentGetOperation']) || $new) {
            $this->instances['assignmentGetOperation'] = Yii::createObject($this->modelClasses['assignmentGetOperation']);
        }

        $query = $this->getAssignmentQuery();
        $this->instances['assignmentGetOperation']->setQuery($query);

        return $this->instances['assignmentGetOperation'];
    }

    /**
     * Установить значение атрибуту.
     *
     * @param array $modelClasses список классов.
     *
     * @return void
     */
    public function setModelClasses(array $modelClasses)
    {
        $this->modelClasses = $modelClasses;
    }

    /**
     * Метод возвращает назначение заданной роли указанному профилю.
     *
     * @param integer $roleId    Идентификатор роли.
     * @param integer $profileId Идентификатор профиля.
     *
     * @return AuthAssignmentActiveRecord|mixed
     */
    public function findAssignByRoleAndProfile($roleId, $profileId)
    {
        return $this->getAssignmentQuery()->byRoleId($roleId)->byProfileId($profileId)->one();
    }
}
