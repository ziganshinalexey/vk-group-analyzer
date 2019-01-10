<?php

namespace Userstory\ModuleAdmin\widgets\GridView\assets;

use Userstory\ModuleAdmin\assets\JqueryAsset;
use yii\grid\GridViewAsset as YiiGridViewAsset;

/**
 * GridViewAsset. Переопределяет стандартный бандл Yii.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @package Userstory\ModuleAdmin\widgets\ActiveForm\assets
 */
class GridViewAsset extends YiiGridViewAsset
{
    /**
     * Здесь хранится список зависимостей.
     *
     * @var array $depends
     */
    public $depends = [JqueryAsset::class];
}
