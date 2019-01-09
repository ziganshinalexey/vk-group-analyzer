<?php

namespace Userstory\ComponentHelpers\helpers;

use yii\helpers\ArrayHelper as YiiArrayHelper;

/**
 * Class ArrayHelper.
 * Расширение возможностей хелпера по работе с массивом.
 *
 * @package Userstory\ComponentHelpers\helpers
 */
class ArrayHelper extends YiiArrayHelper
{
    /**
     * Преобразовать число в тип integer.
     *
     * @param array $val массив значений.
     *
     * @return array
     */
    public static function toInt(array $val)
    {
        foreach ($val as $key => $item) {
            if (is_array($item)) {
                $val[$key] = static::toInt($item);
            } else {
                $val[$key] = (int)preg_replace('/[^0-9]/', '', $item);
            }
        }
        return $val;
    }

    /**
     * Метод объединяет списки и возвращает результат.
     * Рассматривает все ключи как ассоциативные, т.е. числовые ключи, не добавляются, а обновляются.
     *
     * @param array $a Список для объединения.
     * @param array $b Список для объединения.
     *
     * @return array
     */
    public static function mergeAssociative(array $a, array $b)
    {
        $args = [$a, $b];
        $res  = array_shift($args);

        while (! empty($args)) {
            $next = (array)array_shift($args);
            foreach ($next as $k => $v) {
                if (is_int($k)) {
                    $res[$k] = $v;
                } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                    $res[$k] = static::mergeAssociative($res[$k], $v);
                } else {
                    $res[$k] = $v;
                }
            }
        }

        return $res;
    }
}
