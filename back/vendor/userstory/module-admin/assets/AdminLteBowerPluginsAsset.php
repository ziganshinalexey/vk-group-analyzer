<?php

namespace Userstory\ModuleAdmin\assets;

use yii\web\AssetBundle;

/**
 * Класс пакета отображения админки в стиле AdminLTE (плагины).
 *
 * AdminLte AssetBundle
 */
class AdminLteBowerPluginsAsset extends AssetBundle
{
    /**
     * Определение расположения исходников для пакета.
     *
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components';

    /**
     * Определение стилей для админки.
     *
     * @var array
     */
    public $css = [
        'bootstrap-daterangepicker/daterangepicker.css',
        'select2/dist/css/select2.min.css',
    ];

    /**
     * Определение яваскриптов для библиотеки.
     *
     * @var array
     */
    public $js = [
        'jquery-slimscroll/jquery.slimscroll.min.js',
        'moment/min/moment.min.js',
        'bootstrap-daterangepicker/daterangepicker.js',
        'select2/dist/js/select2.min.js',
    ];

    /**
     * Здесь хранится список зависимостей.
     *
     * @var array $depends
     */
    public $depends = [JqueryAsset::class];
}
