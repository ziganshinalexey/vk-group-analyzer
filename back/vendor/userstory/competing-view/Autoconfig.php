<?php

namespace Userstory\CompetingView;

use Userstory\ComponentAutoconfig\interfaces\console\AutoconfigInterface as ConsoleAutoconfigInterface;
use Userstory\ComponentAutoconfig\interfaces\web\AutoconfigInterface;

/**
 * Автоконфиг для стандартных компонентов.
 *
 * @package Userstory\ModuleFaq
 */
class Autoconfig implements AutoconfigInterface, ConsoleAutoconfigInterface
{
    /**
     * Данный метод возвращает массив с конфигурацией данного модуля.
     *
     * @return array
     */
    public static function getWebConfig()
    {
        return require __DIR__ . '/config/module.config.php';
    }

    /**
     * Данный метод возвращает массив с конфигурацией данного модуля для консоли.
     *
     * @return array
     */
    public static function getConsoleConfig()
    {
        return require __DIR__ . '/config/console.config.php';
    }
}
