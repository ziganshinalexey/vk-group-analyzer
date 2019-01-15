<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces;

/**
 * Интерфейс объекта, работающего со списоком ИД.
 */
interface WithIdListInterface
{
    /**
     * Метод возвращает список ИД.
     *
     * @return int[]
     */
    public function getIdList(): array;

    /**
     * Метод устанавливает список ИД.
     *
     * @param int[] $dtoList Список ДТО сущностей.
     *
     * @return static
     */
    public function setIdList(array $dtoList);
}
