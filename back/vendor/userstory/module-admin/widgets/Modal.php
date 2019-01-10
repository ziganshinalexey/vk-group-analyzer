<?php

namespace Userstory\ModuleAdmin\widgets;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\ModuleAdmin\assets\BootstrapPluginAsset;
use yii\bootstrap\Modal as BootstrapModal;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Класс виджета для отображения модального окна.
 *
 * @package Userstory\ModuleAdmin\widgets
 */
class Modal extends BootstrapModal
{
    /**
     * Флаг для принудительного обновления контента через url.
     *
     * @var boolean
     */
    public $forceUpdate = false;

    /**
     * Ключ модального окна из списка $modalTypes.
     *
     * @var string
     */
    public $type = 'default';

    /**
     * Ключ для вертикального центрирования модального окна.
     *
     * @var boolean
     */
    public $verticalCenter = true;

    /**
     * Массив типов модального окна (отображаются по разному).
     *
     * @var array
     */
    public $modalTypes = [
        'default' => [
            'class' => '',
        ],
        'primary' => [
            'class' => 'modal-primary',
        ],
        'info'    => [
            'class' => 'modal-info',
        ],
        'warning' => [
            'class' => 'modal-warning',
        ],
        'success' => [
            'class' => 'modal-success',
        ],
        'danger'  => [
            'class' => 'modal-danger',
        ],
    ];

    /**
     * Инициализация HTML-атрибутов для модального окна.
     *
     * @return void
     */
    protected function initOptions()
    {
        $typeClass = ArrayHelper::getValue($this->modalTypes, $this->type);
        Html::addCssClass($this->options, $typeClass);

        if ($this->forceUpdate) {
            $this->options['data-force-update'] = true;
        }

        if ($this->verticalCenter) {
            Html::addCssClass($this->options, 'modal-center');
        }

        parent::initOptions();
    }

    /**
     * Регистрирует Bootstrap-плагин.
     * Переопределение требуется, что бы можно было использовать JQuery3.
     *
     * @param string $name Название плагина.
     *
     * @throws \yii\base\InvalidParamException Если в процессе htmlEncode произошли какие-то ошибки.
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
