<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\group\operations;

use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\filters\MultiFilterOperationInterface;

/**
 * Интерфейс операции, реализующей логику поиска сущности.
 */
interface MultiFindOperationInterface extends BaseFindOperationInterface, MultiFilterOperationInterface
{
    /**
     * Метод возвращает все сущности по заданному фильтру в виде массива.
     *
     * @return array
     */
    public function allAsArray(): array;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "ВК группа".
     *
     * @param string $activity Атрибут "Название" сущности "ВК группа".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byActivity(string $activity, string $operator = '='): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "ВК группа".
     *
     * @param string $description Атрибут "Название" сущности "ВК группа".
     * @param string $operator    Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byDescription(string $description, string $operator = '='): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "ВК группа".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "ВК группа".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byId(int $id, string $operator = '='): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по нескольким значениям PK сущности "ВК группа".
     *
     * @param array $ids Список PK  сущности "ВК группа".
     *
     * @return MultiFindOperationInterface
     */
    public function byIds(array $ids): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "ВК группа".
     *
     * @param string $name     Атрибут "Название" сущности "ВК группа".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byName(string $name, string $operator = '='): MultiFindOperationInterface;

    /**
     * Метод возвращает все сущности по заданному фильтру.
     *
     * @return GroupInterface[]
     */
    public function doOperation(): array;

    /**
     * Метод устанавливает лимит получаемых сущностей.
     *
     * @param int $limit Количество необходимых сущностей.
     *
     * @return MultiFindOperationInterface
     */
    public function limit(int $limit): MultiFindOperationInterface;

    /**
     * Метод устанавливает смещение получаемых сущностей.
     *
     * @param int $offset Смещение в списке необходимых сущностей.
     *
     * @return MultiFindOperationInterface
     */
    public function offset(int $offset): MultiFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "activity".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByActivity(string $sortType = 'ASC'): MultiFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "description".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByDescription(string $sortType = 'ASC'): MultiFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "id".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortById(string $sortType = 'ASC'): MultiFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "name".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByName(string $sortType = 'ASC'): MultiFindOperationInterface;
}
