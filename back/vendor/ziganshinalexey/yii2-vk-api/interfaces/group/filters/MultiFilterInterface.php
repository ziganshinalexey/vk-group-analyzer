<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\group\filters;

/**
 * Интерфейс объявляет фильтр форму для сущности "ВК группа".
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
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setActivity(string $value): MultiFilterInterface;

    /**
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setDescription(string $value): MultiFilterInterface;

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "ВК группа".
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
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setName(string $value): MultiFilterInterface;

    /**
     * Метод задает номер записи, с которой нуобходимо сделать выборку.
     *
     * @param int $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setOffset(int $value): MultiFilterInterface;
}
