<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors;

use Userstory\ComponentAutoconfig\interfaces\console\AutoconfigInterface as AutoconfigConsoleInterface;
use Userstory\ComponentAutoconfig\interfaces\web\AutoconfigInterface as AutoconfigWebInterface;

/**
 * Настройки для автоконфига - автоматической сборки конфигурации.
 */
class Autoconfig implements AutoconfigWebInterface, AutoconfigConsoleInterface
{
    /**
     * Метод реализует интерфейс getWebConfig и возвращает настройки для работы в web-режиме.
     *
     * @return array
     */
    public static function getWebConfig(): array
    {
        return require __DIR__ . '/config/web.config.php';
    }

    /**
     * Метод реализует интерфейс getConsoleConfig и возвращает настройки для работы консоли.
     *
     * @return array
     */
    public static function getConsoleConfig(): array
    {
        return require __DIR__ . '/config/console.config.php';
    }
}
