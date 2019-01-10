<?php

namespace Userstory\User\queries;

use yii\db\ActiveQuery;

/**
 * Построитель запросов для модели UserSettings.
 *
 * @package Userstory\User\services
 */
class UserProfileSettingsQuery extends ActiveQuery
{
    /**
     * Добавляем условие выборки.
     *
     * @param integer $id ид записи в таблице.
     *
     * @return static
     */
    public function byForeignKey($id)
    {
        return $this->where(['relationId' => $id]);
    }
}
