<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\interfaces\keyword\operations;

use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\filters\MultiFilterOperationInterface;

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
     * Задает критерий фильтрации выборки по атрибуту "Количество совпадений" сущности "Ключевое фраза".
     *
     * @param int    $coincidenceCount Атрибут "Количество совпадений" сущности "Ключевое фраза".
     * @param string $operator         Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byCoincidenceCount(int $coincidenceCount, string $operator = '='): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "Ключевое фраза".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "Ключевое фраза".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byId(int $id, string $operator = '='): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по нескольким значениям PK сущности "Ключевое фраза".
     *
     * @param array $ids Список PK  сущности "Ключевое фраза".
     *
     * @return MultiFindOperationInterface
     */
    public function byIds(array $ids): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @param int    $personTypeId Атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     * @param string $operator     Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byPersonTypeId(int $personTypeId, string $operator = '='): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Коэффициент" сущности "Ключевое фраза".
     *
     * @param int    $ratio    Атрибут "Коэффициент" сущности "Ключевое фраза".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byRatio(int $ratio, string $operator = '='): MultiFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "Ключевое фраза".
     *
     * @param string $text     Атрибут "Название" сущности "Ключевое фраза".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return MultiFindOperationInterface
     */
    public function byText(string $text, string $operator = '='): MultiFindOperationInterface;

    /**
     * Метод возвращает все сущности по заданному фильтру.
     *
     * @return KeywordInterface[]
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
     * Устанавливает сортировку результатов запроса по полю "coincidenceCount".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByCoincidenceCount(string $sortType = 'ASC'): MultiFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "id".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortById(string $sortType = 'ASC'): MultiFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "personTypeId".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByPersonTypeId(string $sortType = 'ASC'): MultiFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "ratio".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByRatio(string $sortType = 'ASC'): MultiFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "text".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return MultiFindOperationInterface
     */
    public function sortByText(string $sortType = 'ASC'): MultiFindOperationInterface;
}
