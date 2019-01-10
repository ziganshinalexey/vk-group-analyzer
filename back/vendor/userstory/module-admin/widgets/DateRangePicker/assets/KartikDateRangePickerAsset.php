<?php

namespace Userstory\ModuleAdmin\widgets\DateRangePicker\assets;

use kartik\daterange\DateRangePickerAsset as kartiDateRangePickerAsset;
use Userstory\ModuleAdmin\assets\JqueryAsset;

/**
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @since 1.0
 */
class KartikDateRangePickerAsset extends kartiDateRangePickerAsset
{
    /**
     * Здесь хранится список зависимостей.
     *
     * @var array $depends
     */
    public $depends = [
        MomentAsset::class,
        JqueryAsset::class,
    ];
}
