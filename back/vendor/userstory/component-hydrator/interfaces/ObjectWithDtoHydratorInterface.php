<?php

declare(strict_types = 1);

namespace Userstory\ComponentHydrator\interfaces;

/**
 * Интерфейс ObjectWithDtoHydratorInterface.
 * Интерфейс объекта, работающего с гидратором ДТО.
 */
interface ObjectWithDtoHydratorInterface
{
    /**
     * Метод возвращает гидратор ДТО.
     *
     * @return HydratorInterface
     */
    public function getDtoHydrator(): HydratorInterface;

    /**
     * Метод устанавливает гидратор ДТО.
     *
     * @param HydratorInterface $dtoHydrator Новое значение.
     *
     * @return static
     */
    public function setDtoHydrator(HydratorInterface $dtoHydrator);
}
