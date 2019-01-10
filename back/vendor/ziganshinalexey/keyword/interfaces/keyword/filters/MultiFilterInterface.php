<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\interfaces\keyword\filters;

/**
 * Интерфейс объявляет фильтр форму для сущности "Ключевое фраза".
 */
interface MultiFilterInterface extends BaseFilterInterface
{
    /**
     * Метод применяет фильтр к операции над несколькими сущностями.
     *
     * @param MultiFilterOperationInterface $operation Обект реализующий методы фильтров операции.
     *
     * @return MultiFilterOperationInterface
     */
    public function applyFilter(MultiFilterOperationInterface $operation): MultiFilterOperationInterface;

    /**
     * Метод возвращает лимит выводимых записей.
     *
     * @return int
     */
    public function getLimit();

    /**
     * Метод возвращает номер записи, с которой нуобходимо сделать выборку.
     *
     * @return int
     */
    public function getOffset();

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "Ключевое фраза".
     *
     * @param int $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setId(int $value): MultiFilterInterface;

    /**
     * Метод задает лимит выводимых записей.
     *
     * @param int $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setLimit(int $value): MultiFilterInterface;

    /**
     * Метод задает номер записи, с которой нуобходимо сделать выборку.
     *
     * @param int $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setOffset(int $value): MultiFilterInterface;

    /**
     * Метод устанавливает атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @param int $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setPersonTypeId(int $value): MultiFilterInterface;

    /**
     * Метод устанавливает атрибут "Название" сущности "Ключевое фраза".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setText(string $value): MultiFilterInterface;
}
