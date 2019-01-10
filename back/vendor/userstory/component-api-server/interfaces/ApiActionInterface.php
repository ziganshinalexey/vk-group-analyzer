<?php

namespace Userstory\ComponentApiServer\interfaces;

/**
 * Interface ApiActionInterface
 * Интерфейс для всех действий API.
 * Каждый пользовательский класс действия должен реализовывать этот интерфейс.
 *
 * @package Userstory\ComponentApiServer\interfaces
 */
interface ApiActionInterface
{
    /**
     * Метод возвращает пользовательское краткое описание текущего действия.
     *
     * @return array
     */
    public static function info();
}
