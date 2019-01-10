<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\interfaces\personType\filters;

use Userstory\ComponentBase\interfaces\AbstractFilterInterface;

/**
 * Интерфейс объявляет методы фильтра данных.
 */
interface BaseFilterInterface extends AbstractFilterInterface
{
    /**
     * Метод возвращает атрибут "Идентификатор" сущности "Тип личности".
     *
     * @return int
     */
    public function getId();

    /**
     * Метод возвращает атрибут "Название" сущности "Тип личности".
     *
     * @return string
     */
    public function getName();
}
