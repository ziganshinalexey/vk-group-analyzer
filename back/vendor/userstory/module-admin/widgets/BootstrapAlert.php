<?php

namespace Userstory\ModuleAdmin\widgets;

use Userstory\ModuleAdmin\assets\BootstrapPluginAsset;
use yii\bootstrap\Alert as BaseAlert;
use yii\helpers\Json;

/**
 * Класс BootstrapAlert Переопределение требуется, что бы можно было использовать JQuery3.
 */
class BootstrapAlert extends BaseAlert
{
    /**
     * Регистрирует Bootstrap плагины.
     *
     * Переопределение требуется, что бы можно было использовать JQuery3.
     *
     * @param string $name Имя для Bootstrap плагина.
     *
     * @return void
     */
    protected function registerPlugin($name)
    {
        $view = $this->getView();

        BootstrapPluginAsset::register($view);

        $id = $this->options['id'];

        if (false !== $this->clientOptions) {
            $options = empty($this->clientOptions) ? '' : Json::htmlEncode($this->clientOptions);
            $js      = 'jQuery(\'#' . $id . '\').' . $name . '(' . $options . ');';
            $view->registerJs($js);
        }

        $this->registerClientEvents();
    }
}
