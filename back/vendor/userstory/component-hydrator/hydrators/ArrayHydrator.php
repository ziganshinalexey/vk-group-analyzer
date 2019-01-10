<?php

namespace Userstory\ComponentHydrator\hydrators;

use ReflectionException;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\ComponentHydrator\traits\ToArrayTrait;
use Userstory\ComponentHydrator\traits\ToObjectTrait;

/**
 * Класс ArrayHydrator для работы через формат массива.
 *
 * @package Userstory\ComponentHydrator\hydrators
 */
class ArrayHydrator implements HydratorInterface
{
    use ToObjectTrait, ToArrayTrait;

    /**
     * Метод извлекает данные из переданного объекта.
     *
     * @param mixed $object Объект, из которого извлекаются данные.
     *
     * @return mixed
     *
     * @throws ReflectionException Генерирует, если класс отсутствует.
     */
    public function extract($object)
    {
        return $this->convertToArray($object);
    }

    /**
     * Метод наполняет переданный объект переданными данными.
     *
     * @param mixed $data   Данные для наполнения объекта.
     * @param mixed $object Объект для наполнения.
     *
     * @return mixed
     *
     * @throws ReflectionException Генерирует, если класс отсутствует.
     */
    public function hydrate($data, $object)
    {
        return $this->convertToObject($data, $object);
    }
}
