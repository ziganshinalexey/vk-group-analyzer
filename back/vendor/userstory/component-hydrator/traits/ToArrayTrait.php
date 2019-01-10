<?php

namespace Userstory\ComponentHydrator\traits;

use ReflectionClass;
use ReflectionException;

/**
 * Трэит ToArrayTrait реализует метод преобразования объекта в массив.
 *
 * @package Userstory\ComponentHydrator\traits
 */
trait ToArrayTrait
{
    /**
     * Метод извлекает данные из переданного объекта.
     *
     * @param mixed $object Объект, из которого извлекаются данные.
     *
     * @return array
     *
     * @throws ReflectionException Генерирует в случае если такого класса не существует.
     */
    protected function convertToArray($object)
    {
        $reflectionClass = new ReflectionClass(get_class($object));
        $result          = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $changeAccessible = false;
            if ($property->isPrivate() || $property->isProtected()) {
                $changeAccessible = true;
                $property->setAccessible(true);
            }
            $result[$property->getName()] = $property->getValue($object);
            if ($changeAccessible) {
                $property->setAccessible(false);
            }
        }
        return $result;
    }
}
