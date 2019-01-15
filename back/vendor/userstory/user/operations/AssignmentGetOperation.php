<?php

namespace Userstory\User\operations;

use yii\base\Model;
use Userstory\User\entities\AuthAssignmentActiveRecord;
use Userstory\User\queries\AuthAssignmentQuery;

/**
 * Класс для получения моделей полномочий.
 *
 * @package Userstory\User\models
 */
class AssignmentGetOperation extends Model
{
    /**
     * Объект построителя запросов к таблице полномочий.
     *
     * @var AuthAssignmentQuery|null
     */
    protected $query;

    /**
     * Получить объект полномочия пользователя по роли.
     *
     * @param integer $profileId идентификатор профиля.
     * @param integer $roleId    идентификатор роли.
     *
     * @return AuthAssignmentActiveRecord|null|mixed
     */
    public function getByUserRole($profileId, $roleId)
    {
        return $this->query->byProfileId($profileId)->byRoleId($roleId)->one();
    }

    /**
     * Проверить, присвоена ли роль пользователю.
     *
     * @param integer $profileId идентификатор профиля.
     * @param integer $roleId    идентификатор роли.
     *
     * @return boolean
     */
    public function isExist($profileId, $roleId)
    {
        return $this->query->byProfileId($profileId)->byRoleId($roleId)->exists();
    }

    /**
     * Установить значение атрибута.
     *
     * @param AuthAssignmentQuery $query объект построителя запросов.
     *
     * @return void
     */
    public function setQuery(AuthAssignmentQuery $query)
    {
        $this->query = $query;
    }
}
