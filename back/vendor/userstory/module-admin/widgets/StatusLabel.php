<?php

namespace Userstory\ModuleAdmin\widgets;

use yii\bootstrap\Widget;
use yii\helpers\Html;

/**
 * Класс виджета для отображения лейбла со статусом.
 *
 * @package Userstory\ModuleAdmin\widgets
 */
class StatusLabel extends Widget
{
    /**
     * Массив типов лейблов (отображаются по разному).
     *
     * @var array
     */
    public $labelTypes = [
        'error'   => 'label label-danger',
        'danger'  => 'label label-danger',
        'success' => 'label label-success',
        'info'    => 'label label-info',
        'warning' => 'label label-warning',
        'primary' => 'label label-primary',
    ];

    /**
     * Текст (название статуса) внутри лейбла.
     *
     * @var string|null
     */
    public $text;

    /**
     * Тип лейбла, соответствующий $labelTypes.
     *
     * @var string
     */
    public $type = 'info';

    /**
     * HTML-атрибуты для лейбла со статусом.
     *
     * @var array
     */
    public $option = [
        'class' => '',
    ];

    /**
     * Инициализация виджета для отображения лейбла со статусом.
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->option['class'] = $this->labelTypes[$this->type] . ' ' . $this->option['class'];
    }

    /**
     * Рендер лейбла со статусом.
     *
     * @return string
     */
    public function run()
    {
        return Html::tag('span', $this->text, $this->option);
    }
}
