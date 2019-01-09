<?php

namespace Userstory\ComponentAutoconfig\interfaces\web;

/**
 * Метод определеяет интерфейс для конфигурации веб-приложения.
 *
 * @package Userstory\ComponentAutoconfig\components\web
 */
interface AutoconfigInterface
{
    /**
     * Возвращает конфигурацию для веб-приложения.
     *
     * @return array
     */
    public static function getWebConfig();
}
