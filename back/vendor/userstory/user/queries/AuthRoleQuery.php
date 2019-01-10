<?php

namespace Userstory\User\queries;

use yii\db\ActiveQuery;

/**
 * Построитель запросов для табилцы ролей.
 *
 * @package Userstory\User\queries
 */
class AuthRoleQuery extends ActiveQuery
{
    /**
     * Добавить условие выборки.
     *
     * @param string $name Название роли.
     *
     * @return static
     */
    public function byName($name)
    {
        return $this->andWhere(['name' => $name]);
    }

    /**
     * Добавить условие выборки.
     *
     * @param integer $id ID роли пользователя.
     *
     * @return static
     */
    public function byId($id)
    {
        return $this->andWhere(['id' => $id]);
    }
}
