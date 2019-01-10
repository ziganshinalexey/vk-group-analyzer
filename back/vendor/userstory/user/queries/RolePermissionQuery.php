<?php

namespace Userstory\User\queries;

use yii\db\ActiveQuery;

/**
 * Построитель запросов для таблицы ролей.
 *
 * @package Userstory\User\queries
 */
class RolePermissionQuery extends ActiveQuery
{
    /**
     * Добавить условие выборки по ID.
     *
     * @param string $roleId Идентификатор роли.
     *
     * @return static
     */
    public function byId($roleId)
    {
        return $this->andWhere(['roleId' => $roleId]);
    }
}
