<?php

namespace Userstory\ModuleAdmin\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;

/**
 * Класс Ассет бандл для публикации ассетов админки на сайте.
 */
class AdminAsset extends AssetBundle
{
    /**
     * Здесь хранится путь к ресурсам.
     *
     * @var array $sourcePath
     */
    public $sourcePath = '@vendor/userstory/module-admin/www/build';

    /**
     * Здесь хранится список файлов стилей.
     *
     * @var array $css
     */
    public $css = ['common.min.css'];

    /**
     * Здесь хранится список файлов скриптов.
     *
     * @var array $js
     */
    public $js = ['common.min.js'];

    /**
     * Здесь хранится список зависимостей.
     *
     * @var array $depends
     */
    public $depends = [
        YiiAsset::class,
        BootstrapAsset::class,
    ];
}
