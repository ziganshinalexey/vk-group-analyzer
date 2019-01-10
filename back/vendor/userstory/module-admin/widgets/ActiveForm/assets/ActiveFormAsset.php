<?php

namespace Userstory\ModuleAdmin\widgets\ActiveForm\assets;

use Userstory\ModuleAdmin\assets\JqueryAsset;
use yii\widgets\ActiveFormAsset as YiiActiveFormAsset;

/**
 * ActiveFormAsset. Переопределяет стандартный бандл Yii.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @package Userstory\ModuleAdmin\widgets\ActiveForm\assets
 */
class ActiveFormAsset extends YiiActiveFormAsset
{
    /**
     * Здесь хранится список зависимостей.
     *
     * @var array $depends
     */
    public $depends = [JqueryAsset::class];
}
