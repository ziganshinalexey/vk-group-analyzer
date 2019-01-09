<?php

namespace Userstory\ComponentAutoconfig\components\console;

use Userstory\ComponentAutoconfig\components\Autoconfig as BaseAutoconfig;
use Userstory\ComponentAutoconfig\interfaces\console\AutoconfigInterface;
use Userstory\ComponentHelpers\helpers\ArrayHelper;

/**
 * Автосборщик конфигурации консольного приложения.
 *
 * @package Userstory\ComponentAutoconfig\components\web
 */
class Autoconfig extends BaseAutoconfig
{
    /**
     * Метод загружает консольную конфигурацию конкретного модуля.
     *
     * @param string $class имя класса загружаемого модуля.
     *
     * @return void
     */
    protected function loadModuleConfig($class)
    {
        parent::loadModuleConfig($class);

        if (is_subclass_of($class, AutoconfigInterface::class) || method_exists($class, 'getConsoleConfig')) {
            $this->config = ArrayHelper::merge($this->config, $class::getConsoleConfig());
        }
    }
}
