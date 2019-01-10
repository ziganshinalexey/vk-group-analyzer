<?php

namespace Userstory\ComponentHydrator\interfaces;

use ReflectionException;

/**
 * Интерфейс FormatterInterface обьявляет методы преобразователя.
 *
 * @package Userstory\ComponentHydrator\interfaces
 */
interface FormatterInterface
{
    /**
     * Метод преобразует объект в массив.
     *
     * @param mixed $object Объект, из которого извлекаются данные.
     *
     * @return mixed
     *
     * @throws ReflectionException Генерирует, если класс отсутствует.
     */
    public function format($object);
}
