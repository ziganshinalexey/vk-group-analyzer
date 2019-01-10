<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\interfaces\personType\filters;

use Userstory\ComponentBase\interfaces\ObjectWithErrorsInterface;

/**
 * Интерфейс объявляет методы фильтрации операций.
 */
interface BaseFilterOperationInterface extends ObjectWithErrorsInterface
{
    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "Тип личности".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "Тип личности".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byId(int $id, string $operator = '=');

    /**
     * Задает критерий фильтрации выборки по нескольким значениям PK сущности "Тип личности".
     *
     * @param array $ids Список PK  сущности "Тип личности".
     *
     * @return BaseFilterOperationInterface
     */
    public function byIds(array $ids);

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "Тип личности".
     *
     * @param string $name     Атрибут "Название" сущности "Тип личности".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byName(string $name, string $operator = '=');

    /**
     * Устанавливает сортировку результатов запроса по полю "id".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return BaseFilterOperationInterface
     */
    public function sortById(string $sortType = 'ASC');

    /**
     * Устанавливает сортировку результатов запроса по полю "name".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return BaseFilterOperationInterface
     */
    public function sortByName(string $sortType = 'ASC');
}
