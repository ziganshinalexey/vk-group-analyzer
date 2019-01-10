<?php

namespace Userstory\User\queries;

use yii;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * Построитель запросов для модели UserAuth.
 *
 * @package Userstory\User\services
 */
class UserAuthQuery extends ActiveQuery
{
    /**
     * Добавляем условие выборки.
     *
     * @param integer $id ид записи в таблице.
     *
     * @return static
     */
    public function byId($id)
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * Добавляем условие выборки.
     *
     * @param string $login Логин профиля пользователя.
     *
     * @return static
     */
    public function byLogin($login)
    {
        return $this->andWhere(['login' => mb_strtolower($login, Yii::$app->charset)]);
    }

    /**
     * Метод добавляет условие выборки пользователей с логином, который совпадает с искомым.
     *
     * @param string $login Логин для сравнения.
     *
     * @return static
     */
    public function bySameLogin($login)
    {
        $condition = new Expression(sprintf('lower(%s) = lower(:login)', Yii::$app->db->quoteColumnName('login')));
        return $this->andWhere($condition, ['login' => $login]);
    }
}
