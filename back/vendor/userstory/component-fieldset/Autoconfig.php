<?php

namespace Userstory\ComponentFieldset;

use Userstory\ComponentAutoconfig\interfaces\console\AutoconfigInterface as ConsoleAutoconfigInterface;
use Userstory\ComponentAutoconfig\interfaces\web\AutoconfigInterface;

/**
 * Class Autoconfig.
 * Данный класс отвечает за получение конфигурации данного модуля.
 *
 * @package Userstory\ModuleUser
 */
class Autoconfig implements ConsoleAutoconfigInterface, AutoconfigInterface
{
    /**
     * Данный метод возвращает конфигурацию данного модуля.
     *
     * @return array
     */
    public static function getConsoleConfig()
    {
        return require __DIR__ . '/config/console.config.php';
    }

    /**
     * Возвращает конфигурацию для веб-приложения.
     *
     * @return array
     */
    public static function getWebConfig()
    {
        return require __DIR__ . '/config/web.config.php';
    }
}
