<?php

namespace Userstory\User\queries;

use yii\db\ActiveQuery;

/**
 * Class UserRecoveryQuery.
 * Рассширяем необходимые возможности для модели восстановлении пароля.
 *
 * @package Userstory\User\models
 */
class UserRecoveryQuery extends ActiveQuery
{
    /**
     * Выборка по коду восстановления.
     *
     * @param string $code код восстановления.
     *
     * @return UserRecoveryQuery
     */
    public function byCode($code)
    {
        return $this->andWhere(['code' => $code]);
    }
}
