<?php

namespace Userstory\ModuleAdmin\widgets\Pjax\assets;

use Userstory\ModuleAdmin\assets\JqueryAsset;
use yii\widgets\PjaxAsset as YiiPjaxAsset;

/**
 * Данный бандл подключает javascript-файлы , необходимые для виджета [[Pjax]].
 *
 * @package Userstory\ModuleAdmin\widgets\Pjax\assets
 */
class PjaxAsset extends YiiPjaxAsset
{
    /**
     * Здесь хранится путь к ресурсам.
     *
     * @var array $sourcePath
     */
    public $sourcePath = '@vendor/userstory/module-admin/www/build';

    /**
     * Здесь хранится список файлов скриптов.
     *
     * @var array $js
     */
    public $js = ['jquery.pjax.min.js'];

    /**
     * Здесь хранится список зависимостей.
     *
     * @var array $depends
     */
    public $depends = [JqueryAsset::class];
}
