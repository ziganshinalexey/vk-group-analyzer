<?php

namespace Userstory\ModuleAdmin\assets;

use yii\web\YiiAsset as YiiYiiAsset;

/**
 * Бандл для подключения скриптов Yii
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @package Userstory\ModuleAdmin\assets
 */
class YiiAsset extends YiiYiiAsset
{
    /**
     * Здесь хранится список зависимостей.
     *
     * @var array $depends
     */
    public $depends = [JqueryAsset::class];
}
