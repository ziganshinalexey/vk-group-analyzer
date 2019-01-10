<?php

namespace Userstory\ModuleAdmin\assets;

use yii\web\AssetBundle;

/**
 * Бандл для JQuery3 скриптов.
 *
 * @package Userstory\ModuleAdmin\assets
 */
class JqueryAsset extends AssetBundle
{
    /**
     * Здесь хранится путь к ресурсам.
     *
     * @var array $sourcePath
     */
    public $sourcePath = '@vendor/components/jquery';
    /**
     * Здесь хранится список файлов скриптов.
     *
     * @var array $js
     */
    public $js = [YII_DEBUG ? 'jquery.js' : 'jquery.min.js'];
}
