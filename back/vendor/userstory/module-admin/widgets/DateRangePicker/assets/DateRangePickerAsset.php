<?php

namespace Userstory\ModuleAdmin\widgets\DateRangePicker\assets;

use yii\web\AssetBundle;

/**
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @since 1.0
 */
class DateRangePickerAsset extends AssetBundle
{
    /**
     * Определение расположения исходников для пакета.
     *
     * @var string
     */
    public $sourcePath = '@vendor/userstory/module-admin/widgets/DateRangePicker/www/build';

    /**
     * Определение стилей для админки.
     *
     * @var array
     */

    public $js = ['date-range-picker.min.js'];

    /**
     * Здесь хранится список зависимостей.
     *
     * @var array $depends
     */
    public $depends = [KartikDateRangePickerAsset::class];
}
