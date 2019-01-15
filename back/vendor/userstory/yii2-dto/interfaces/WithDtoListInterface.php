<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces;

/**
 * Интерфейс объекта, работающего со списоком ДТО.
 */
interface WithDtoListInterface
{
    /**
     * Метод возвращает список ДТО сущностей.
     *
     * @return BaseDtoInterface[]
     */
    public function getDtoList(): array;

    /**
     * Метод устанавливает список ДТО сущностей.
     *
     * @param BaseDtoInterface[] $dtoList Список ДТО сущностей.
     *
     * @return static
     */
    public function setDtoList(array $dtoList);
}
