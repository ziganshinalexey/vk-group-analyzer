<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\interfaces\personType\filters;

/**
 * Интерфейс объявляет фильтр форму для сущности "Тип личности".
 */
interface SingleFilterInterface extends BaseFilterInterface
{
    /**
     * Метод применяет фильтр к операции над одной сущности.
     *
     * @param SingleFilterOperationInterface $operation Обект реализующий методы фильтров операции.
     *
     * @return SingleFilterOperationInterface
     */
    public function applyFilter(SingleFilterOperationInterface $operation): SingleFilterOperationInterface;

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "Тип личности".
     *
     * @param int $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setId(int $value): SingleFilterInterface;

    /**
     * Метод устанавливает атрибут "Название" сущности "Тип личности".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setName(string $value): SingleFilterInterface;
}
