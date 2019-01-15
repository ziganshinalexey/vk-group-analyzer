<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\group\operations;

use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\filters\SingleFilterOperationInterface;

/**
 * Интерфейс операции, реализующей логику поиска сущности.
 */
interface SingleFindOperationInterface extends BaseFindOperationInterface, SingleFilterOperationInterface
{
    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "ВК группа".
     *
     * @param string $activity Атрибут "Название" сущности "ВК группа".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byActivity(string $activity, string $operator = '='): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "ВК группа".
     *
     * @param string $description Атрибут "Название" сущности "ВК группа".
     * @param string $operator    Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byDescription(string $description, string $operator = '='): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "ВК группа".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "ВК группа".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byId(int $id, string $operator = '='): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по нескольким значениям PK сущности "ВК группа".
     *
     * @param array $ids Список PK  сущности "ВК группа".
     *
     * @return SingleFindOperationInterface
     */
    public function byIds(array $ids): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "ВК группа".
     *
     * @param string $name     Атрибут "Название" сущности "ВК группа".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byName(string $name, string $operator = '='): SingleFindOperationInterface;

    /**
     * Метод возвращает одну сущность по заданному фильтру.
     *
     * @return GroupInterface|null
     */
    public function doOperation(): ?GroupInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "activity".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByActivity(string $sortType = 'ASC'): SingleFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "description".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByDescription(string $sortType = 'ASC'): SingleFindOperationInterface;

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
