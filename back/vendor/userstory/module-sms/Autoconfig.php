<?php

namespace Userstory\ModuleSms;

use Userstory\ComponentAutoconfig\interfaces\AutoconfigInterface;

/**
 * Class Autoconfig.
 * Данный класс отвечает за получение конфигурации данного модуля.
 *
 * @package Userstory\ModuleUser
 */
class Autoconfig implements AutoconfigInterface
{
    /**
     * Данный метод возвращает конфигурацию данного модуля.
     *
     * @return array
     */
    public static function getConfig()
    {
        return require __DIR__ . '/config/module.config.php';
    }
}
