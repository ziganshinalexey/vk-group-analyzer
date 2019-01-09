<?php

namespace Userstory\ComponentAutoconfig\interfaces;

/**
 * Interface AutoconfigInterface
 * Данный интерфейс содержит объявление метода getConfig(). Каждый пользовательский
 * модуль должен реализовать данный интерфейс.
 *
 * @package Userstory\ComponentAutoconfig\interfaces
 */
interface AutoconfigInterface
{
    /**
     * Данный метод возвращает конфигурацию пользовательского модуля.
     *
     * @return array
     */
    public static function getConfig();
}
