<?php

namespace Userstory\ModuleAdmin;

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
     * Возвращаем массив настроек модуля.
     *
     * @return array
     */
    public static function getWebConfig()
    {
        return require __DIR__ . '/config/module.config.php';
    }

    /**
     * Возвращаем массив настроек модуля.
     *
     * @return array
     */
    public static function getConsoleConfig()
    {
        return require __DIR__ . '/config/console.config.php';
    }
}
