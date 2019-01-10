<?php

namespace Userstory\ModuleAdmin\widgets\MaskedInputMulti\assets;

use Userstory\ModuleAdmin\assets\MaskedInputAsset;
use yii\web\AssetBundle;

/**
 * Ассет бандл для виджета [[MaskedInputMulti]].
 */
class MaskedInputMultiAsset extends AssetBundle
{
    /**
     * Здесь хранится путь к ресурсам.
     *
     * @var array $sourcePath
     */
    public $sourcePath = '@vendor/userstory/module-admin/widgets/MaskedInputMulti/www/build';

    /**
     * Здесь хранится список файлов скриптов.
     *
     * @var array $js
     */
    public $js = ['jquery.maskedinput-multi.min.js'];

    /**
     * Зависимости от других подключаемых модулей.
     *
     * @var array $depends
     */
    public $depends = [MaskedInputAsset::class];
}
