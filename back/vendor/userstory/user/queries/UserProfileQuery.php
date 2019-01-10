<?php

namespace Userstory\User\queries;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * Построитель запросов для профиля пользователя.
 *
 * @package Userstory\User\services
 */
class UserProfileQuery extends ActiveQuery
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
     * @param array $idList Список ид записей в таблице.
     *
     * @return static
     */
    public function byIdList(array $idList)
    {
        return $this->andWhere(['id' => $idList]);
    }

    /**
     * Добавляем условие выборки.
     *
     * @param string $email почта пользователя.
     *
     * @return static
     */
    public function byEmail($email)
    {
        return $this->andWhere(['email' => mb_strtolower($email, Yii::$app->charset)]);
    }

    /**
     * исключаем из выборки одного пользователя пользователя.
     *
     * @param integer $profileId идентификатор профиля.
     *
     * @return $this
     */
    public function exceptProfileId($profileId)
    {
        return $this->andFilterWhere([
            '!=',
            'id',
            $profileId,
        ]);
    }

    /**
     * Добавляем условие выборки.
     *
     * @param string $userName уникальное имя пользователя.
     *
     * @return static
     */
    public function byUserName($userName)
    {
        return $this->andWhere(['username' => mb_strtolower($userName, Yii::$app->charset)]);
    }

    /**
     * Добавляем условие выборки.
     *
     * @param string $phone номер телефона пользователя.
     *
     * @return static
     */
    public function byPhone($phone)
    {
        return $this->andWhere(['phone' => $phone]);
    }

    /**
     * Связываем с дополнительными настройками пользователя.
     *
     * @return static
     */
    public function withSettings()
    {
        return $this->joinWith('additionalProperties');
    }

    /**
     * Исключаем из выборки профиля пои ИД.
     *
     * @param array $ids список идентификаторов профилей.
     *
     * @return static
     */
    public function byNotIds(array $ids)
    {
        $ids = ArrayHelper::toInt($ids);
        return $this->andWhere([
            'not in',
            'id',
            $ids,
        ]);
    }

    /**
     * Выборка по поиску совпадения строки в полях имени и фамилии.
     *
     * @param string $q поисковая строка.
     *
     * @return static
     */
    public function byLikeFIO($q)
    {
        $like = 'mysql' === Yii::$app->db->driverName ? 'LIKE' : 'ILIKE';
        $q    = Yii::$app->db->quoteValue('%' . $q . '%');
        return $this->andWhere((new Expression(sprintf("CONCAT_WS(' ', {{firstName}}, {{lastName}}) %s %s", $like, $q))));
    }
}
