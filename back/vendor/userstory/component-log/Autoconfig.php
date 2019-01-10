<?php

namespace Userstory\ComponentLog;

use Userstory\ComponentAutoconfig\interfaces\console\AutoconfigInterface as ConsoleAutoconfigInterface;
use Userstory\ComponentAutoconfig\interfaces\web\AutoconfigInterface;

/**
 * Автоконфиг для стандартных компонентов.
 *
 * @package Userstory\ComponentLog
 */
class Autoconfig implements AutoconfigInterface, ConsoleAutoconfigInterface
{
    /**
     * Метод реализует класс интерфейса getConfig.
     *
     * @return array
     */
    public static function getWebConfig()
    {
        return require __DIR__ . '/config/web.config.php';
    }

    /**
     * Метод реализует класс интерфейса getConfig.
     *
     * @return array
     */
    public static function getConsoleConfig()
    {
        return require __DIR__ . '/config/console.config.php';
    }
}
