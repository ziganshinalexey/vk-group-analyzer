<?php

namespace Userstory\ModuleAdmin\assets;

use yii\web\AssetBundle;

/**
 * Класс пакета отображения админки в стиле AdminLTE (плагины).
 *
 * AdminLte AssetBundle
 */
class AdminLtePluginsAsset extends AssetBundle
{
    /**
     * Определение расположения исходников для пакета.
     *
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';

    /**
     * Определение стилей для админки.
     *
     * @var array
     */
    public $css = ['iCheck/all.css'];

    /**
     * Определение яваскриптов для библиотеки.
     *
     * @var array
     */
    public $js = ['iCheck/icheck.min.js'];

    /**
     * Здесь хранится список зависимостей.
     *
     * @var array $depends
     */
    public $depends = [
        JqueryAsset::class,
        AdminLteBowerPluginsAsset::class,
    ];
}
