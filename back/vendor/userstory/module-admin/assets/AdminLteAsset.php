<?php

namespace Userstory\ModuleAdmin\assets;

use rmrevin\yii\fontawesome\AssetBundle as FontAwesomeAssetBundle;
use yii\web\AssetBundle;

/**
 * Класс пакета отображения админки в стиле AdminLTE (скрипты).
 *
 * AdminLte AssetBundle
 */
class AdminLteAsset extends AssetBundle
{
    /**
     * Определение расположения исходников для пакета.
     *
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';

    /**
     * Определение яваскриптов для библиотеки.
     *
     * @var array
     */
    public $js = ['js/adminlte.min.js'];

    /**
     * Зависимости от других подключаемых модулей.
     *
     * @var array
     */
    public $depends = [
        FontAwesomeAssetBundle::class,
        YiiAsset::class,
        BootstrapPluginAsset::class,
        AdminLtePluginsAsset::class,
        AdminLteCSSAsset::class,
    ];
}
