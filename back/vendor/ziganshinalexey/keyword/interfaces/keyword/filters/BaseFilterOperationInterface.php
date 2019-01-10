<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\interfaces\keyword\filters;

use Userstory\ComponentBase\interfaces\ObjectWithErrorsInterface;

/**
 * Интерфейс объявляет методы фильтрации операций.
 */
interface BaseFilterOperationInterface extends ObjectWithErrorsInterface
{
    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "Ключевое фраза".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "Ключевое фраза".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byId(int $id, string $operator = '=');

    /**
     * Задает критерий фильтрации выборки по нескольким значениям PK сущности "Ключевое фраза".
     *
     * @param array $ids Список PK  сущности "Ключевое фраза".
     *
     * @return BaseFilterOperationInterface
     */
    public function byIds(array $ids);

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @param int    $personTypeId Атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     * @param string $operator     Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byPersonTypeId(int $personTypeId, string $operator = '=');

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "Ключевое фраза".
     *
     * @param string $text     Атрибут "Название" сущности "Ключевое фраза".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byText(string $text, string $operator = '=');

    /**
     * Устанавливает сортировку результатов запроса по полю "id".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return BaseFilterOperationInterface
     */
    public function sortById(string $sortType = 'ASC');

    /**
     * Устанавливает сортировку результатов запроса по полю "personTypeId".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return BaseFilterOperationInterface
     */
    public function sortByPersonTypeId(string $sortType = 'ASC');

    /**
     * Устанавливает сортировку результатов запроса по полю "text".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return BaseFilterOperationInterface
     */
    public function sortByText(string $sortType = 'ASC');
}
