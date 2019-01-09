<?php

namespace Userstory\ComponentHelpers\helpers;

use yii;

/**
 * Class ViewHelper. Содержит вспомогательные методы для вьюх.
 *
 * @package Userstory\ComponentBase\models
 */
class ViewHelper
{
    /**
     * "Да"/"Нет"-хелпер для отображения текстовых значений флагов в админке.
     *
     * @param mixed $value Проверяемое значение.
     *
     * @return string
     */
    public static function yesOrNo($value)
    {
        return $value ? Yii::t('yii', 'Yes') : Yii::t('yii', 'No');
    }
}
