<?php

namespace Userstory\ModuleAdmin\components;

use Userstory\ModuleAdmin\assets\JqueryAsset;
use yii\web\View as YiiView;

/**
 * Class View.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @package Userstory\ModuleAdmin\components
 */
class View extends YiiView
{
    /**
     * Регистрирует блок JS-кода.
     * Переопределение требуется, что бы можно было использовать JQuery3.
     *
     * @param string  $js       Блок JS-кода для геристрации.
     * @param integer $position Поизиция на странице для регистрации.
     * @param string  $key      Ключ, который будет идентифицировать этот блок JS-кода.
     *
     * @return void
     */
    public function registerJs($js, $position = self::POS_READY, $key = null)
    {
        $key                       = $key ? : md5($js);
        $this->js[$position][$key] = $js;
        if (self::POS_READY === $position || self::POS_LOAD === $position) {
            JqueryAsset::register($this);
        }
    }
}
