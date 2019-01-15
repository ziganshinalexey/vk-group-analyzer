<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user\filters;

/**
 * Интерфейс объявляет фильтр форму для сущности "ВК пользователь".
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
     * Метод устанавливает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setFacultyName(string $value): SingleFilterInterface;

    /**
     * Метод устанавливает атрибут "Имя" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setFirstName(string $value): SingleFilterInterface;

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "ВК пользователь".
     *
     * @param int $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setId(int $value): SingleFilterInterface;

    /**
     * Метод устанавливает атрибут "Фамилия" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setLastName(string $value): SingleFilterInterface;

    /**
     * Метод устанавливает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setPhoto(string $value): SingleFilterInterface;

    /**
     * Метод устанавливает атрибут "Университет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setUniversityName(string $value): SingleFilterInterface;
}
