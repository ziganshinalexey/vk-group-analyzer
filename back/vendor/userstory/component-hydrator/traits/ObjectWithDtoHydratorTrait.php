<?php

declare(strict_types = 1);

namespace Userstory\ComponentHydrator\traits;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;

/**
 * Трейт ObjectWithHydratorTrait.
 * Трейт содержит общую логику объекта, работающего с гидратором ДТО.
 */
trait ObjectWithDtoHydratorTrait
{
    /**
     * Объект гидратора ДТО для работы.
     *
     * @var HydratorInterface|null
     */
    protected $dtoHydrator;

    /**
     * Метод возвращает гидаратор ДТО.
     *
     * @return HydratorInterface
     */
    public function getDtoHydrator(): HydratorInterface
    {
        return $this->dtoHydrator;
    }

    /**
     * Метод устанавливает гидратор ДТО.
     *
     * @param HydratorInterface $dtoHydrator Новое значение.
     *
     * @return static
     */
    public function setDtoHydrator(HydratorInterface $dtoHydrator)
    {
        $this->dtoHydrator = $dtoHydrator;
        return $this;
    }
}
