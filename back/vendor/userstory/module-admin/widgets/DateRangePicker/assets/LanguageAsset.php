<?php

namespace Userstory\ModuleAdmin\widgets\DateRangePicker\assets;

use kartik\daterange\LanguageAsset as kartikLanguageAsset;
use Userstory\ModuleAdmin\assets\JqueryAsset;

/**
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * Language Asset bundle for \kartik\daterange\DateRangePicker.
 *
 * @since 1.0
 */
class LanguageAsset extends kartikLanguageAsset
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
