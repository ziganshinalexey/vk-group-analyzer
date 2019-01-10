<?php

namespace Userstory\ModuleAdmin\widgets\DateRangePicker\assets;

use Userstory\ModuleAdmin\assets\JqueryAsset;
use kartik\base\WidgetAsset as kartikWidgetAsset;

/**
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * Common base widget asset bundle for all Krajee widgets
 *
 * @since 1.0
 */
class WidgetAsset extends kartikWidgetAsset
{
    /**
     * Здесь хранится список зависимостей.
     *
     * @var array $depends
     */
    public $depends = [JqueryAsset::class];
}
