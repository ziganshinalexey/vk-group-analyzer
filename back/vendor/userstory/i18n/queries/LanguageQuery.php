<?php

namespace Userstory\I18n\queries;

use yii\db\ActiveQuery;

/**
 * Class LanguageQuery.
 * Рассширяем необходимые возможности для модели.
 *
 * @package Userstory\I18n\entities
 */
class LanguageQuery extends ActiveQuery
{
    /**
     * Выборка по коду языка из базы.
     *
     * @param string $code код языка.
     *
     * @return LanguageQuery
     */
    public function byCode($code)
    {
        return $this->andWhere(['code' => $code]);
    }

    /**
     * Выборка языков по умолчанию или не по умолчанию.
     *
     * @param boolean $default выбирать дефолтные или не дефолтные.
     *
     * @return $this
     */
    public function byDefault($default = true)
    {
        return $this->andWhere(['isDefault' => (int)$default]);
    }

    /**
     * Выборка опубликованных или неопубликованных языков.
     *
     * @param boolean $active Степень опубликованности языков.
     *
     * @return LanguageQuery
     */
    public function byActive($active = true)
    {
        return $this->andWhere(['isActive' => (int)$active]);
    }

    /**
     * Выборка языков по их Айди.
     *
     * @param integer $id Айди языка.
     *
     * @return $this
     */
    public function byId($id)
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * Выборка языков по их урлу.
     *
     * @param string $url урл языка.
     *
     * @return LanguageQuery
     */
    public function byUrl($url)
    {
        return $this->andWhere(['url' => $url]);
    }

    /**
     * Выборка, не включающая в себя передаваемое значение указанного поля.
     *
     * @param string $value Передаваемое значение.
     * @param string $field Название поля, по умолчанию id.
     *
     * @return LanguageQuery
     */
    public function notInclude($value, $field = 'id')
    {
        if (null === $value) {
            return $this->andWhere([
                'not',
                [$field => 'NULL'],
            ]);
        }
        return $this->andWhere([
            '<>',
            $field,
            $value,
        ]);
    }

    /**
     * Сортировка языков: в начале идёт дефолтный. затем - все прочие опубликованные, затем не опубликованные.
     *
     * @return LanguageQuery
     */
    public function sort()
    {
        return $this->addOrderBy('isDefault DESC, isActive DESC');
    }
}
