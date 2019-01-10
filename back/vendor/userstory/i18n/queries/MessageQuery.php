<?php

namespace Userstory\I18n\queries;

use yii\db\ActiveQuery;

/**
 * Class MessageQuery Рассширяем необходимые возможности для модели.
 *
 * @package Userstory\I18n\queries
 */
class MessageQuery extends ActiveQuery
{
    /**
     * Выборка Сообщений по Айди Языка.
     *
     * @param integer $langId Айди языка.
     *
     * @return $this
     */
    public function byLanguageId($langId)
    {
        return $this->andWhere(['languageId' => $langId]);
    }

    /**
     * Выборка по идентификатору сообщения.
     *
     * @param integer $id Айди сообщения.
     *
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * Выборка по категории переводов.
     *
     * @param string $category Название категории переводов.
     *
     * @return $this
     */
    public function byCategory($category)
    {
        return $this->joinWith('sourceMessage')->andWhere([
            'LIKE',
            'category',
            $category,
        ]);
    }
}
