<?php

namespace Userstory\ModuleAdmin\widgets\DateRangePicker;

use kartik\daterange\DateRangePicker as KartikDateRangePicker;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\ModuleAdmin\components\View;
use Userstory\ModuleAdmin\widgets\DateRangePicker\assets\DateRangePickerAsset;
use Userstory\ModuleAdmin\widgets\DateRangePicker\assets\LanguageAsset;
use Userstory\ModuleAdmin\widgets\DateRangePicker\assets\MomentAsset;
use Userstory\ModuleAdmin\widgets\DateRangePicker\assets\WidgetAsset;
use yii\helpers\Html;

/**
 * Класс виджета для отображения датапикера.
 *
 * Описание работы плагина http://demos.krajee.com/widget-details/datepicker.
 *
 * Переопределение требуется, что бы можно было использовать JQuery3.
 */
class DateRangePicker extends KartikDateRangePicker
{
    /**
     * Название jQuery плагина для этого виджета.
     *
     * @var string
     */
    const PLUGIN_NAME = 'usDateRangePicker';

    /**
     * Js класс для этого виджета.
     */
    const JS_CLASS_DATERANGEPICKER = 'j-active-drop-up';

    /**
     * Переопределение переменной родителя, $this->_format.
     *
     * @var string|null
     */
    protected $format;

    /**
     * Метод проверяет наличие переменной.
     *
     * @param string $field Параметр поля.
     *
     * @return mixed|null.
     */
    protected function getValue($field)
    {
        if (! property_exists($this, $field)) {
            return null;
        }
        return $this->$field;
    }

    /**
     * Регистрируем клиентские Ассеты.
     *
     * @return void
     */
    public function registerAssets()
    {
        $view = $this->getView();
        MomentAsset::register($view);
        $input = 'jQuery("#' . $this->options['id'] . '")';
        $id    = $input;
        if ($this->hideInput) {
            $id = 'jQuery("#' . $this->containerOptions['id'] . '")';
        }
        if (! empty($value)) {
            LanguageAsset::register($view)->js[] = $value;
        }
        DateRangePickerAsset::register($view);
        $format    = $this->getValue('_format');
        $rangeJs   = '';
        $separator = $this->getValue('_separator');
        if (empty($this->callback)) {
            $val = "start.format('" . $format . "') + '" . $separator . "' + end.format('" . $format . "')";
            if (ArrayHelper::getValue($this->pluginOptions, 'singleDatePicker', false)) {
                $val = "start.format('" . $format . "')";
            }
            $rangeJs = $this->getRangeJs('start') . $this->getRangeJs('end');
            $change  = $rangeJs . $input . ".val(val).trigger('change');";
            if ($this->hideInput) {
                $script = 'var val=' . $val . ';' . $id . ".find('.range-value').html(val);" . $change;
            } elseif ($this->useWithAddon) {
                $id     = $input . ".closest('.input-group')";
                $script = 'var val=' . $val . ';' . $change;
            } elseif (! $this->autoUpdateOnInit) {
                $script = 'var val=' . $val . ';' . $change;
            } else {
                $this->registerPlugin($this->pluginName, $id);
                return;
            }
            $this->callback = 'function(start,end,label){' . $script . '}';
        }
        $js = <<< JS
{$input}.off('change.kvdrp').on('change.kvdrp', function() {
    var drp = {$id}.data('{$this->pluginName}'), now;
    if ($(this).val() || !drp) {
        return;
    } now = moment().format('{$this->_format}') || '';
    drp.setStartDate(now);
    drp.setEndDate(now);
    {$rangeJs} });
JS;

        $view->registerJs($js);
        $this->registerPlugin($this->pluginName, $id, null, $this->callback);
        $view->registerJs($id . '.' . self::PLUGIN_NAME . '();');
    }

    /**
     * Регистрируем клиентские Ассеты.
     *
     * @param string  $js  Js-код, который требуется зарегистрировать.
     * @param integer $pos Положение календаря.
     * @param string  $key Это ключ, который идентифицирует блок дж-кода.
     *
     * @return void
     */
    public function registerWidgetJs($js, $pos = View::POS_READY, $key = null)
    {
        if (empty($js)) {
            return;
        }
        $view = $this->getView();
        WidgetAsset::register($view);
        $view->registerJs($js, $pos, $key);
        if (! empty($this->pjaxContainerId) && ( View::POS_LOAD === $pos || View::POS_READY === $pos )) {
            $pjax       = 'jQuery("#' . $this->pjaxContainerId . '")';
            $evComplete = 'pjax:complete.' . hash('crc32', $js);
            $script     = 'setTimeout(function(){ ' . $js . ' }, 100);';
            $view->registerJs($pjax . ".off('" . $evComplete . "').on('" . $evComplete . "',function(){ " . $script . ' });');

            // Hack fix for browser back and forward buttons.
            if ($this->enablePopStateFix) {
                $view->registerJs("window.addEventListener('popstate',function(){window.location.reload();});");
            }
        }
    }

    /**
     * Генерит инпут (ругается что короткое описание, добавил текста).
     *
     * @param string  $type тип инпута.
     * @param boolean $list показывает, имеет ли инпут dropdown.
     *
     * @return string  the рендер инпут макап.
     */
    protected function getInput($type, $list = false)
    {
        Html::addCssClass($this->options, self::JS_CLASS_DATERANGEPICKER);
        if ($this->hasModel()) {
            $input = 'active' . ucfirst($type);
            if ($list) {
                return Html::$input($this->model, $this->attribute, $this->data, $this->options);
            } else {
                return Html::$input($this->model, $this->attribute, $this->options);
            }
        }
        $input   = $type;
        $checked = false;
        if ('radio' === $type || 'checkbox' === $type) {
            $this->options['value'] = $this->value;
            $checked                = ArrayHelper::remove($this->options, 'checked', '');
            if (empty($checked) && ! empty($this->value)) {
                $checked = ( 0 === $this->value ) ? false : true;
            } elseif (empty($checked)) {
                $checked = false;
            }
        }
        if ($list) {
            return Html::$input($this->name, $this->value, $this->data, $this->options);
        } else {
            if ('checkbox' === $type || 'radio' === $type) {
                return Html::$input($this->name, $checked, $this->options);
            } else {
                return Html::$input($this->name, $this->value, $this->options);
            }
        }
    }
}
