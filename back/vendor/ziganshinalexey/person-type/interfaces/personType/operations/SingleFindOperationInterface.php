<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\interfaces\personType\operations;

use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;
use Ziganshinalexey\PersonType\interfaces\personType\filters\SingleFilterOperationInterface;

/**
 * Интерфейс операции, реализующей логику поиска сущности.
 */
interface SingleFindOperationInterface extends BaseFindOperationInterface, SingleFilterOperationInterface
{
    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "Тип личности".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "Тип личности".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byId(int $id, string $operator = '='): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по нескольким значениям PK сущности "Тип личности".
     *
     * @param array $ids Список PK  сущности "Тип личности".
     *
     * @return SingleFindOperationInterface
     */
    public function byIds(array $ids): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "Тип личности".
     *
     * @param string $name     Атрибут "Название" сущности "Тип личности".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byName(string $name, string $operator = '='): SingleFindOperationInterface;

    /**
     * Метод возвращает одну сущность по заданному фильтру.
     *
     * @return PersonTypeInterface|null
     */
    public function doOperation(): ?PersonTypeInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "id".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return SingleFindOperationInterface
     */
    public function sortById(string $sortType = 'ASC'): SingleFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "name".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByName(string $sortType = 'ASC'): SingleFindOperationInterface;
}
