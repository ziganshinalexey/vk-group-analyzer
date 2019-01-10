<?php

namespace Userstory\ModuleAdmin\widgets\ActiveForm\assets;

use Userstory\ModuleAdmin\assets\JqueryAsset;
use yii\widgets\ActiveFormAsset as YiiActiveFormAsset;

/**
 * Ассет бандл для виджета [[ActiveForm]].
 *
 * @package Userstory\ModuleAdmin\widgets\ActiveForm\assets
 */
class ActiveFormWidgetAsset extends YiiActiveFormAsset
{
    /**
     * Здесь хранится путь к ресурсам.
     *
     * @var array $sourcePath
     */
    public $sourcePath = '@vendor/userstory/module-admin/widgets/ActiveForm/www/build';

    /**
     * Здесь хранится список файлов скриптов.
     *
     * @var array $js
     */
    public $js = ['active-form.min.js'];

    /**
     * Здесь хранится список зависимостей.
     *
     * @var array $depends
     */
    public $depends = [JqueryAsset::class];
}
