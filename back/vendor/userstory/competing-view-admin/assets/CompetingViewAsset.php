<?php

namespace Userstory\CompetingViewAdmin\assets;

use Userstory\ModuleAdmin\assets\YiiAsset;
use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;

/**
 * Class CompetingViewAsset.
 * Класс комплекта ресурсов для модуля "Конкуретный просмотр".
 *
 * @package userstory\ModuleCompetingView\assets
 */
class CompetingViewAsset extends AssetBundle
{
    /**
     * Путь к источнику файлов комплекта.
     *
     * @var string
     */
    public $sourcePath = '@vendor/userstory/competing-view-admin/assets';

    /**
     * CSS файлы для публикации.
     *
     * @var array
     */
    public $css = ['css/competing-view-widget.css'];

    /**
     * JS файлы, которые надо опубликовать.
     *
     * @var array
     */
    public $js = ['js/competing-view-widget.min.js'];

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
