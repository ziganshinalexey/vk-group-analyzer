<?php

namespace Userstory\ComponentHydrator\formatters;

use ReflectionException;
use Userstory\ComponentHydrator\interfaces\FormatterInterface;
use Userstory\ComponentHydrator\traits\ToArrayTrait;

/**
 * Класс ArrayFormatter реализует методы преобразования плоских моделей в массив.
 *
 * @package Userstory\ComponentHydrator\formatters
 */
class ArrayFormatter implements FormatterInterface
{
    use ToArrayTrait;

    /**
     * Метод преобразует объект в массив.
     *
     * @param mixed $object Объект, из которого извлекаются данные.
     *
     * @return mixed
     *
     * @throws ReflectionException Генерирует, если класс отсутствует.
     */
    public function format($object)
    {
        return $this->convertToArray($object);
    }
}
