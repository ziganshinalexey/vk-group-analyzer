<?php

namespace Userstory\ModuleAdmin\assets;

use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset as YiiBootstrapPluginAsset;

/**
 * Бандл для Twitter-bootstrap скриптов.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @package Userstory\ModuleAdmin\assets
 */
class BootstrapPluginAsset extends YiiBootstrapPluginAsset
{
    /**
     * Здесь хранится список зависимостей.
     *
     * @var array $depends
     */
    public $depends = [
        JqueryAsset::class,
        BootstrapAsset::class,
    ];
}
