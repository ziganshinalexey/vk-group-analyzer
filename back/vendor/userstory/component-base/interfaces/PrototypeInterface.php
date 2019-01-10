<?php

namespace Userstory\ComponentBase\interfaces;

/**
 * Интерфейс PrototypeInterface.
 * Интерфейс для класса, реализующего паттерн "прототип".
 *
 * @package Userstory\ComponentBase\interfaces
 */
interface PrototypeInterface
{
    /**
     * Метод копирует текущий объект.
     *
     * @return static
     */
    public function copy();
}
