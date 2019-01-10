<?php

namespace Userstory\ComponentBase\traits;

use yii\data\ActiveDataProvider;

/**
 * Trait ModelSearchTrait.
 * Трейт для базовых операций в моделях поиска.
 *
 * @package app\models\search
 */
trait ModelSearchTrait
{
    /**
     * Данный метод добавляет сортировку по атрибуту.
     *
     * @param ActiveDataProvider $dataProvider  Провайдер данных.
     * @param string             $attributeName Имя атрибута.
     * @param string             $aliasName     Имя псевдонима.
     *
     * @return void
     */
    protected static function addSortForAttribute(ActiveDataProvider $dataProvider, $attributeName, $aliasName = null)
    {
        if (! isset( $aliasName )) {
            $aliasName = $attributeName;
        }

        $dataProvider->sort->attributes[$attributeName] = [
            'asc'  => [$aliasName => SORT_ASC],
            'desc' => [$aliasName => SORT_DESC],
        ];
    }

    /**
     * Данный метод добавляет сортировку по составному атрибуту.
     *
     * @param ActiveDataProvider $dataProvider  Провайдер данных.
     * @param string             $attributeName Имя атрибута.
     * @param array              $composite     Составные части атрибута.
     *
     * @return void
     */
    protected static function addSortForCompositeAttribute(ActiveDataProvider $dataProvider, $attributeName, array $composite = [])
    {
        $dataProvider->sort->attributes[$attributeName] = [
            'asc'  => array_fill_keys($composite, SORT_ASC),
            'desc' => array_fill_keys($composite, SORT_DESC),
        ];
    }

    /**
     * Метод позволяет искать по булевым значениям через строковые запросы.
     *
     * К примеру:
     *
     * - 'Да' соответствует 1
     * - 'Нет' соответствует 0.
     *
     * @param string $attribute  Имя атрибута для сравнения.
     * @param string $trueValue  Утверждающее значение.
     * @param string $falseValue Отрицающее значение.
     *
     * @return integer
     */
    protected function getBooleanFilter($attribute, $trueValue = 'Да', $falseValue = 'Нет')
    {
        $filterValue = null;

        if ('' !== $this->{$attribute} || null === $this->{$attribute}) {

            switch (strtolower($this->{$attribute})) {
                case strtolower($trueValue):
                    $filterValue = 1;
                    break;

                case strtolower($falseValue):
                    $filterValue = 0;
                    break;

                default:
                    $filterValue = $this->{$attribute};
                    break;
            }
        }

        return $filterValue;
    }

    /**
     * Метод позволяет искать по null значениям через строковые запросы.
     *
     * @param string $attribute  Имя атрибута для сравнения.
     * @param string $trueValue  Утверждающее значение.
     * @param string $falseValue Отрицающее значение.
     *
     * @return array
     */
    protected function getNullFilter($attribute, $trueValue = 'Да', $falseValue = 'Нет')
    {
        if ($trueValue === $this->{$attribute}) {
            return ['is not', $attribute, null];
        }

        if ($falseValue === $this->{$attribute}) {
            return [$attribute => null];
        }

        return [];
    }
}
