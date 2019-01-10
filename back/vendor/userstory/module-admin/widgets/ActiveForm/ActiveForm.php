<?php

namespace Userstory\ModuleAdmin\widgets\ActiveForm;

use Userstory\ModuleAdmin\widgets\ActiveForm\assets\ActiveFormAsset;
use Userstory\ModuleAdmin\widgets\ActiveForm\assets\ActiveFormWidgetAsset;
use yii\base\InvalidCallException;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm as YiiActiveForm;

/**
 * ActiveForm - виджет, который строит интерактивную HTML-форму для одной или нескольких моделей.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 */
class ActiveForm extends YiiActiveForm
{
    /**
     * Название jQuery плагина для этого виджета.
     *
     * @var string
     */
    const PLUGIN_NAME = 'usActiveForm';

    /**
     * Js класс для этого виджета.
     */
    const JS_CLASS_FORM = 'j-active-form';

    /**
     * Js класс для кнопки submit.
     */
    const JS_CLASS_SUBMIT = 'j-active-form-submit';

    /**
     * Js класс для кнопки reset.
     */
    const JS_CLASS_RESET = 'j-active-form-reset';

    /**
     * Запускает виджет.
     * Переопределение требуется, что бы можно было использовать JQuery3.
     *
     * @throws InvalidCallException если количество вызовой `beginField()` и `endField()` не совпадают.
     * @throws \yii\base\InvalidParamException если параметры какого-то из вызываемых методоы неверны.
     *
     * @return void
     */
    public function run()
    {
        /*
        todo придумать как обойти приватный атрибут
        if (! empty($this->_fields)) {
            throw new InvalidCallException('Each beginField() should have a matching endField() call.');
        }
        */

        $content = ob_get_clean();
        Html::addCssClass($this->options, self::JS_CLASS_FORM);
        echo Html::beginForm($this->action, $this->method, $this->options);
        echo $content;

        if ($this->enableClientScript) {
            $id         = $this->options['id'];
            $options    = Json::htmlEncode($this->getClientOptions());
            $attributes = Json::htmlEncode($this->attributes);
            $view       = $this->getView();
            ActiveFormAsset::register($view);
            ActiveFormWidgetAsset::register($view);
            $view->registerJs('jQuery(\'#' . $id . '\').yiiActiveForm(' . $attributes . ', ' . $options . ');');
            $view->registerJs('jQuery(\'#' . $id . '\').' . self::PLUGIN_NAME . '();');
        }

        echo Html::endForm();
    }

    /**
     * Рендер кнопки reset для формы.
     *
     * @param string $content      Содержимое, заключенное в тег кнопки.
     * @param array  $resetOptions HTML-атрибуты для кнопки.
     *
     * @return string
     */
    public function resetButton($content = 'Reset', array $resetOptions = [])
    {
        $defaultOptions = ['class' => 'btn btn-default'];
        $options        = array_merge($defaultOptions, $resetOptions);

        Html::addCssClass($options, self::JS_CLASS_RESET);

        return Html::resetButton($content, $options);
    }

    /**
     * Рендер кнопки submit для формы.
     *
     * @param string  $content       Содержимое, заключенное в тег кнопки.
     * @param array   $submitOptions HTML-атрибуты для кнопки.
     * @param boolean $hide          Флаг для скрытия кнопки до редактирования полей.
     *
     * @return string
     */
    public function submitButton($content = 'Submit', array $submitOptions = [], $hide = true)
    {
        $defaultOptions = [
            'class' => 'btn btn-primary',
            'data'  => [],
        ];
        $options        = array_merge($defaultOptions, $submitOptions);

        Html::addCssClass($options, self::JS_CLASS_SUBMIT);
        if ($hide) {
            Html::addCssClass($options, 'hide');
            $options['data']['active-form-hide'] = true;
        }

        return Html::submitButton($content, $options);
    }
}
