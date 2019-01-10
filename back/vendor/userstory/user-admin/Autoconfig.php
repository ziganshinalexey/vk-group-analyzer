<?php

namespace Userstory\UserAdmin;

use Userstory\ComponentAutoconfig\interfaces\console\AutoconfigInterface as ConsoleAutoconfigInterface;
use Userstory\ComponentAutoconfig\interfaces\web\AutoconfigInterface as WebAutoconfigInterface;

/**
 * Class Autoconfig.
 * Данный класс отвечает за получение конфигурации данного модуля.
 *
 * @package Userstory\UserAdmin
 */
class Autoconfig implements WebAutoconfigInterface, ConsoleAutoconfigInterface
{
    /**
     * Данный метод возвращает конфигурацию данного модуля.
     *
     * @return array
     */
    public static function getWebConfig()
    {
        return require __DIR__ . '/config/web.config.php';
    }

    /**
     * Данный метод возвращает конфигурацию данного модуля.
     *
     * @return array
     */
    public static function getConsoleConfig()
    {
        return require __DIR__ . '/config/console.config.php';
    }
}
