<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Пример класса ассет-бандла.
 */
class AppAsset extends AssetBundle
{
    /**
     * URL к веб-публичному каталогу, где содержатся файлы ассет-бандла. Можно задавать алиасы.
     *
     * @var string
     */
    public $sourcePath = '@app/assetsSource/src';

    /**
     * Список публикуемых js-файлов.
     *
     * @var array
     */
    public $js = ['index.js'];
}
