<?php

namespace Userstory\ComponentHydrator\hydrators;

use ReflectionException;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;

/**
 * Класс JsonHydrator для работы через формат массива.
 *
 * @package Userstory\ComponentHydrator\hydrators
 */
class JsonHydrator extends ArrayHydrator implements HydratorInterface
{
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
        return json_encode(parent::convertToArray($object));
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
        return json_encode(parent::convertToObject($data, $object));
    }
}
