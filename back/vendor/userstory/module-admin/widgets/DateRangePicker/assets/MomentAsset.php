<?php

namespace Userstory\ModuleAdmin\widgets\DateRangePicker\assets;

use kartik\daterange\MomentAsset as kartikMomentAsset;
use Userstory\ModuleAdmin\assets\JqueryAsset;

/**
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * Moment Asset bundle for \kartik\daterange\DateRangePicker.
 *
 * @since 1.0
 */
class MomentAsset extends kartikMomentAsset
{
    /**
     * Здесь хранится список зависимостей.
     *
     * @var array $depends
     */
    public $depends = [JqueryAsset::class];
}
