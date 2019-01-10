<?php

namespace Userstory\ModuleAdmin\widgets\NavBar;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\ModuleAdmin\assets\BootstrapPluginAsset;
use yii\base\InvalidCallException;
use yii\bootstrap\NavBar as YiiNavBar;
use yii\helpers\Html;

/**
 * NavBar рендерит навигационный HTML-компонет.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @package Userstory\ModuleAdmin\widgets\NavBar
 */
class NavBar extends YiiNavBar
{
    /**
     * Запускает виджет.
     * Переопределение требуется, что бы можно было использовать JQuery3.
     *
     * @throws InvalidCallException если количество вызовой `beginField()` и `endField()` не совпадают.
     * @throws \yii\base\InvalidParamException если параметры какого-то из вызываемых методоы неверны.
     *
     * @return void
     */
    public function run()
    {
        $tag = ArrayHelper::remove($this->containerOptions, 'tag', 'div');
        echo Html::endTag($tag);
        if ($this->renderInnerContainer) {
            echo Html::endTag('div');
        }
        $tag = ArrayHelper::remove($this->options, 'tag', 'nav');
        echo Html::endTag($tag);
        BootstrapPluginAsset::register($this->getView());
    }
}
