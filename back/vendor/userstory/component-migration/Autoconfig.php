<?php

namespace Userstory\ComponentMigration;

use Userstory\ComponentAutoconfig\interfaces\console\AutoconfigInterface;

/**
 * Автоконфигурация для консольного приложения.
 *
 * @package Userstory\ComponentMigration
 */
class Autoconfig implements AutoconfigInterface
{
    /**
     * Определение консольной конфигурации компонента.
     *
     * @return array
     */
    public static function getConsoleConfig()
    {
        return require __DIR__ . '/config/console.config.php';
    }
}
