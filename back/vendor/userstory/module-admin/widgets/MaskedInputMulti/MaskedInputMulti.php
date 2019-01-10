<?php

namespace Userstory\ModuleAdmin\widgets\MaskedInputMulti;

use Userstory\ModuleAdmin\widgets\MaskedInputMulti\assets\MaskedInputMultiAsset;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * MaskedInputMulti виджет используется для отображения инпута с динамической маской.
 */
class MaskedInputMulti extends InputWidget
{
    /**
     * Название jQuery плагина для этого виджета.
     *
     * @var string
     */
    const PLUGIN_NAME = 'multiMaskedInput';

    /**
     * Js класс для этого виджета.
     */
    const JS_CLASS = 'j-mask-phone';

    /**
     * Тип инпута. Поддерживаются только «text» и «tel».
     *
     * @var string
     */
    public $type = 'text';

    /**
     * HTML-атрибуты для инпута.
     *
     * @var array
     */
    public $options = ['class' => 'form-control'];

    /**
     * Рендер виджета и подключение ассетов.
     *
     * @return void
     */
    public function run()
    {
        $this->registerClientScript();
        Html::addCssClass($this->options, self::JS_CLASS);

        if ($this->hasModel()) {
            echo Html::activeInput($this->type, $this->model, $this->attribute, $this->options);
        } else {
            echo Html::input($this->type, $this->name, $this->value, $this->options);
        }
    }

    /**
     * Регистрация необходимых скриптов.
     *
     * @return void
     */
    public function registerClientScript()
    {
        $view = $this->getView();
        $id   = $this->options['id'];
        $js   = 'jQuery("#' . $id . '").' . self::PLUGIN_NAME . '();';
        MaskedInputMultiAsset::register($view);
        $view->registerJs($js);
    }
}
