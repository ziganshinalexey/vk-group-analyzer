<?php

namespace Ziganshinalexey\KeywordAdmin\assets;

use yii\web\AssetBundle;

/**
 * Класс Ассет бандл для публикации ассетов админки на сайте.
 */
class KeywordAdminAsset extends AssetBundle
{
    /**
     * Здесь хранится путь к ресурсам.
     *
     * @var array $sourcePath
     */
    public $sourcePath = '@vendor/ziganshinalexey/keyword-admin/assetsSource';

    /**
     * Здесь хранится список файлов стилей.
     *
     * @var array $css
     */
    public $css = ['styles.css'];

    /**
     * Здесь хранится список файлов скриптов.
     *
     * @var array $js
     */
    public $js = ['index.js'];

    /**
     * Здесь хранится список зависимостей.
     *
     * @var array $depends
     */
//    public $depends = [];
}
