<?php

declare(strict_types = 1);

namespace Userstory\ComponentHydrator\interfaces;

/**
 * Интерфейс ObjectWithHydratorInterface.
 * Интерфейс объекта, работающего с объектом гидратором.
 */
interface ObjectWithHydratorInterface
{
    /**
     * Метод возвращает гидратор ДТО.
     *
     * @return HydratorInterface
     */
    public function getHydrator(): HydratorInterface;

    /**
     * Метод устанавливает гидратор ДТО.
     *
     * @param HydratorInterface $hydrator Новое значение.
     *
     * @return static
     */
    public function setHydrator(HydratorInterface $hydrator);
}
