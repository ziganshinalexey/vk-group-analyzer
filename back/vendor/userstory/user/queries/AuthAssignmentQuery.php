<?php

namespace Userstory\User\queries;

use yii\db\ActiveQuery;

/**
 * Класс построителя запросов для таблицы полномочий.
 *
 * @package Userstory\User\queries
 */
class AuthAssignmentQuery extends ActiveQuery
{
    /**
     * Добавить условие для выборки.
     *
     * @param integer $id значение для выборки.
     *
     * @return static
     */
    public function byProfileId($id)
    {
        return $this->andWhere(['profileId' => $id]);
    }

    /**
     * Добавить условие для выборки.
     *
     * @param integer $id значение для выборки.
     *
     * @return static
     */
    public function byRoleId($id)
    {
        return $this->andWhere(['roleId' => $id]);
    }
}
