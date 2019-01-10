<?php

namespace Userstory\ComponentHydrator\interfaces;

/**
 * Интерфейс для реализации класса преобразования данных из модели в массив и наоборот.
 *
 * @package Userstory\ComponentHydrator\interfaces
 */
interface HydratorInterface
{
    /**
     * Метод извлекает данные из переданного объекта.
     *
     * @param mixed $object Объект, из которого извлекаются данные.
     *
     * @return mixed
     */
    public function extract($object);

    /**
     * Метод наполняет переданный объект переданными данными.
     *
     * @param mixed $data   Данные для наполнения объекта.
     * @param mixed $object Объект для наполнения.
     *
     * @return mixed
     */
    public function hydrate($data, $object);
}
