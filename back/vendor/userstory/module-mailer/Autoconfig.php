<?php

namespace Userstory\ModuleMailer;

use Userstory\ComponentAutoconfig\interfaces\console\AutoconfigInterface as ConsoleAutoconfigInterface;
use Userstory\ComponentAutoconfig\interfaces\web\AutoconfigInterface;

/**
 * Класс автоконфига отдает конфигурационные настройки модуля.
 *
 * @package Userstory\ModuleAdmin
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
        return require __DIR__ . '/config/module.config.php';
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
