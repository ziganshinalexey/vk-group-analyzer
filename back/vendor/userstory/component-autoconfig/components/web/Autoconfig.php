<?php

namespace Userstory\ComponentAutoconfig\components\web;

use Userstory\ComponentAutoconfig\components\Autoconfig as BaseAutoconfig;
use Userstory\ComponentAutoconfig\interfaces\web\AutoconfigInterface;
use Userstory\ComponentHelpers\helpers\ArrayHelper;

/**
 * Автосборщик конфигурации веб-приложения.
 *
 * @package Userstory\ComponentAutoconfig\components\web
 */
class Autoconfig extends BaseAutoconfig
{
    /**
     * Метод загружает веб-конфигурацию конкретного модуля.
     *
     * @param string $class имя класса загружаемого модуля.
     *
     * @return void
     */
    protected function loadModuleConfig($class)
    {
        parent::loadModuleConfig($class);

        if (is_subclass_of($class, AutoconfigInterface::class) || method_exists($class, 'getWebConfig')) {
            $this->config = ArrayHelper::merge($this->config, $class::getWebConfig());
        }
    }
}
