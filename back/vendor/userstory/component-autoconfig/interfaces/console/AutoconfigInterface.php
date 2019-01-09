<?php

namespace Userstory\ComponentAutoconfig\interfaces\console;

/**
 * Метод определеяет интерфейс для конфигурации консольного приложения.
 *
 * @package Userstory\ComponentAutoconfig\components\console
 */
interface AutoconfigInterface
{
    /**
     * Возвращает конфигурацию для консольного приложения.
     *
     * @return array
     */
    public static function getConsoleConfig();
}
