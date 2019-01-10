<?php

namespace Userstory\ComponentBase;

use Userstory\ComponentAutoconfig\interfaces\web\AutoconfigInterface as AutoconfigWebInterface;
use Userstory\ComponentAutoconfig\interfaces\console\AutoconfigInterface as AutoconfigConsoleInterface;

/**
 * Автоконфиг для стандартных компонентов.
 *
 * @package Userstory\ComponentBase
 */
class Autoconfig implements AutoconfigWebInterface, AutoconfigConsoleInterface
{
    /**
     * Метод реализует класс интерфейса getWebConfig.
     *
     * @return array
     */
    public static function getWebConfig()
    {
        return require __DIR__ . '/config/module.config.php';
    }

    /**
     * Метод реализует класс интерфейса getConsoleConfig.
     *
     * @return array
     */
    public static function getConsoleConfig()
    {
        return require __DIR__ . '/config/console.config.php';
    }
}
