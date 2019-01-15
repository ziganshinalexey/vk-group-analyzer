<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\group\filters;

use Userstory\ComponentBase\interfaces\ObjectWithErrorsInterface;

/**
 * Интерфейс объявляет методы фильтрации операций.
 */
interface BaseFilterOperationInterface extends ObjectWithErrorsInterface
{
    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "ВК группа".
     *
     * @param string $activity Атрибут "Название" сущности "ВК группа".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byActivity(string $activity, string $operator = '=');

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "ВК группа".
     *
     * @param string $description Атрибут "Название" сущности "ВК группа".
     * @param string $operator    Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byDescription(string $description, string $operator = '=');

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "ВК группа".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "ВК группа".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byId(int $id, string $operator = '=');

    /**
     * Задает критерий фильтрации выборки по нескольким значениям PK сущности "ВК группа".
     *
     * @param array $ids Список PK  сущности "ВК группа".
     *
     * @return BaseFilterOperationInterface
     */
    public function byIds(array $ids);

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "ВК группа".
     *
     * @param string $name     Атрибут "Название" сущности "ВК группа".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return BaseFilterOperationInterface
     */
    public function byName(string $name, string $operator = '=');

    /**
     * Устанавливает сортировку результатов запроса по полю "activity".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return BaseFilterOperationInterface
     */
    public function sortByActivity(string $sortType = 'ASC');

    /**
     * Устанавливает сортировку результатов запроса по полю "description".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return BaseFilterOperationInterface
     */
    public function sortByDescription(string $sortType = 'ASC');

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
