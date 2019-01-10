<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\interfaces\keyword\operations;

use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\filters\SingleFilterOperationInterface;

/**
 * Интерфейс операции, реализующей логику поиска сущности.
 */
interface SingleFindOperationInterface extends BaseFindOperationInterface, SingleFilterOperationInterface
{
    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор" сущности "Ключевое фраза".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности "Ключевое фраза".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byId(int $id, string $operator = '='): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по нескольким значениям PK сущности "Ключевое фраза".
     *
     * @param array $ids Список PK  сущности "Ключевое фраза".
     *
     * @return SingleFindOperationInterface
     */
    public function byIds(array $ids): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @param int    $personTypeId Атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     * @param string $operator     Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byPersonTypeId(int $personTypeId, string $operator = '='): SingleFindOperationInterface;

    /**
     * Задает критерий фильтрации выборки по атрибуту "Название" сущности "Ключевое фраза".
     *
     * @param string $text     Атрибут "Название" сущности "Ключевое фраза".
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return SingleFindOperationInterface
     */
    public function byText(string $text, string $operator = '='): SingleFindOperationInterface;

    /**
     * Метод возвращает одну сущность по заданному фильтру.
     *
     * @return KeywordInterface|null
     */
    public function doOperation(): ?KeywordInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "id".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return SingleFindOperationInterface
     */
    public function sortById(string $sortType = 'ASC'): SingleFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "personTypeId".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByPersonTypeId(string $sortType = 'ASC'): SingleFindOperationInterface;

    /**
     * Устанавливает сортировку результатов запроса по полю "text".
     *
     * @param string $sortType Тип сортировки - ASC или DESC.
     *
     * @return SingleFindOperationInterface
     */
    public function sortByText(string $sortType = 'ASC'): SingleFindOperationInterface;
}
