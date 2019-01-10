<?php

declare(strict_types = 1);

namespace Userstory\ComponentHydrator\traits;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;

/**
 * Трейт ObjectWithHydratorTrait.
 * Трейт содержит общую логику объекта, работающего с гидратором ДТО.
 */
trait ObjectWithHydratorTrait
{
    /**
     * Объект гидратора для работы.
     *
     * @var HydratorInterface|null
     */
    protected $hydrator;

    /**
     * Метод возвращает объект гидаратор.
     *
     * @return HydratorInterface
     */
    public function getHydrator(): HydratorInterface
    {
        return $this->hydrator;
    }

    /**
     * Метод устанавливает объект гидратор.
     *
     * @param HydratorInterface $hydrator Новое значение.
     *
     * @return static
     */
    public function setHydrator(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
        return $this;
    }
}
