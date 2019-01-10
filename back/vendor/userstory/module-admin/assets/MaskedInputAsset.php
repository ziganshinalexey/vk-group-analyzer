<?php

namespace Userstory\ModuleAdmin\assets;

use yii\widgets\MaskedInputAsset as YiiMaskedInputAsset;

/**
 * Бандл для виджета [[MaskedInput]].
 *
 * @package Userstory\ModuleAdmin\assets
 */
class MaskedInputAsset extends YiiMaskedInputAsset
{
    /**
     * Зависимости от других подключаемых модулей.
     * Переопределение требуется, что бы можно было использовать JQuery3.
     *
     * @var array
     */
    public $depends = [JqueryAsset::class];
}
