<?php

namespace Userstory\I18n\queries;

use yii\db\ActiveQuery;

/**
 * Class SourceMessageQuery.
 * Рассширяем необходимые возможности для модели.
 *
 * @package Userstory\I18n\queries
 */
class SourceMessageQuery extends ActiveQuery
{
    /**
     * Возвращает исходное сообщение по его Айди.
     *
     * @param integer $id Айди исходного сообщения.
     *
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere(['[[id]]' => $id]);
    }

    /**
     * Выборка исходных сообщений по категории.
     *
     * @param string $category Название категории.
     *
     * @return $this
     */
    public function byCategory($category)
    {
        return $this->andWhere(['[[category]]' => $category]);
    }

    /**
     * Выборка исходных сообщений по сообщению.
     *
     * @param string $message Непосредственно сообщение.
     *
     * @return $this
     */
    public function byMessage($message)
    {
        return $this->andWhere(['message' => $message]);
    }

    /**
     * Метод поиска всех переводов.
     *
     * @param string $needle Фильтр поиска по переводам.
     *
     * @return $this
     */
    public function search($needle)
    {
        return $this->joinWith('messages')->orFilterWhere([
            'LIKE',
            'message',
            $needle,
        ])->orFilterWhere([
            'LIKE',
            'translation',
            $needle,
        ])->orFilterWhere([
            'LIKE',
            'category',
            $needle,
        ])->orFilterWhere([
            'LIKE',
            'comment',
            $needle,
        ]);
    }

    /**
     * Метод поиска перевода по определенному языку.
     *
     * @param integer $languageId Индификатор языка.
     *
     * @return $this
     */
    public function byLaguageId($languageId)
    {
        return $this->andFilterWhere([
            '=',
            'languageId',
            $languageId,
        ]);
    }
}
