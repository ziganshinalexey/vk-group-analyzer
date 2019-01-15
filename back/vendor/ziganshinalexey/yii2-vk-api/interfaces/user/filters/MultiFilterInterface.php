<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user\filters;

/**
 * Интерфейс объявляет фильтр форму для сущности "ВК пользователь".
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
     * Метод устанавливает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setFacultyName(string $value): MultiFilterInterface;

    /**
     * Метод устанавливает атрибут "Имя" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setFirstName(string $value): MultiFilterInterface;

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "ВК пользователь".
     *
     * @param int $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setId(int $value): MultiFilterInterface;

    /**
     * Метод устанавливает атрибут "Фамилия" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setLastName(string $value): MultiFilterInterface;

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
     * Метод устанавливает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setPhoto(string $value): MultiFilterInterface;

    /**
     * Метод устанавливает атрибут "Университет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setUniversityName(string $value): MultiFilterInterface;
}
