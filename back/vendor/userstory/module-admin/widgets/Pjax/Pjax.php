<?php

namespace Userstory\ModuleAdmin\widgets\Pjax;

use Userstory\ModuleAdmin\widgets\Pjax\assets\PjaxAsset;
use yii\helpers\Json;
use yii\widgets\Pjax as YiiPjax;

/**
 * Pjax виджет для интеграции jQuery плагина [pjax].
 *
 * @package Userstory\ModuleAdmin\widgets\Pjax
 */
class Pjax extends YiiPjax
{
    /**
     * Регистрирует нужные JavaScript.
     * Переопределение требуется, что бы можно было использовать JQuery3.
     *
     * @throws \yii\base\InvalidParamException если аргументы какого-либо метода неверные.
     *
     * @return void
     */
    public function registerClientScript()
    {
        $id                              = $this->options['id'];
        $this->clientOptions['push']     = $this->enablePushState;
        $this->clientOptions['replace']  = $this->enableReplaceState;
        $this->clientOptions['timeout']  = $this->timeout;
        $this->clientOptions['scrollTo'] = $this->scrollTo;
        $options                         = Json::htmlEncode($this->clientOptions);
        $js                              = '';
        if (false !== $this->linkSelector) {
            $linkSelector = Json::htmlEncode(null !== $this->linkSelector ? $this->linkSelector : '#' . $id . ' a');
            $js .= 'jQuery(document).pjax(' . $linkSelector . ', "#' . $id . '", ' . $options . ');';
        }
        if (false !== $this->formSelector) {
            $formSelector = Json::htmlEncode(null !== $this->formSelector ? $this->formSelector : '#' . $id . ' form[data-pjax]');
            $submitEvent  = Json::htmlEncode($this->submitEvent);
            $js .= "\njQuery(document)";
            $js .= '.off(' . $submitEvent . ', ' . $formSelector . ')';
            $js .= '.on(' . $submitEvent . ', ' . $formSelector;
            $js .= ', function (event) {jQuery.pjax.submit(event, \'#' . $id . '\', ' . $options . ');});';
        }
        $view = $this->getView();
        PjaxAsset::register($view);

        if ('' !== $js) {
            $view->registerJs($js);
        }
    }
}
