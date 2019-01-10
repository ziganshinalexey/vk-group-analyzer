<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\interfaces\keyword\filters;

/**
 * Интерфейс объявляет фильтр форму для сущности "Ключевое фраза".
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
     * Метод устанавливает атрибут "Идентификатор" сущности "Ключевое фраза".
     *
     * @param int $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setId(int $value): SingleFilterInterface;

    /**
     * Метод устанавливает атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @param int $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setPersonTypeId(int $value): SingleFilterInterface;

    /**
     * Метод устанавливает атрибут "Название" сущности "Ключевое фраза".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setText(string $value): SingleFilterInterface;
}
