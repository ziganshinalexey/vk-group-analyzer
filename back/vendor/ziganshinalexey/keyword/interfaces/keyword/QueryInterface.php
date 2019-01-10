<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\interfaces\keyword;

use yii\db\Expression;
use yii\db\QueryInterface as YiiQueryInterface;

/**
 * Интерфейс опеределяет обертку для формирования критериев выборки данных.
 */
interface QueryInterface extends YiiQueryInterface
{
    /**
     * Выборка по атрибуту "Идентификатор" сущности "Ключевое фраза".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности.
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byId(int $id, string $operator = '='): QueryInterface;

    /**
     * Задает критерий фильтрации по нескольким значениям атрибута "Идентификатор" сущности "Ключевое фраза".
     *
     * @param array $ids Атрибут "Идентификатор" сущности "Ключевое фраза".
     *
     * @return QueryInterface
     */
    public function byIds(array $ids): QueryInterface;

    /**
     * Выборка по атрибуту "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @param int    $personTypeId Атрибут "Идентификатор типа личности" сущности.
     * @param string $operator     Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byPersonTypeId(int $personTypeId, string $operator = '='): QueryInterface;

    /**
     * Выборка по атрибуту "Название" сущности "Ключевое фраза".
     *
     * @param string $text     Атрибут "Название" сущности.
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byText(string $text, string $operator = '='): QueryInterface;

    /**
     * Метод устанавливает FROM-часть формируемого запроса.
     * Метод добавлен в интерфейс, так как отсутствует в родительском интерфейсе.
     * Тем не менее, реализация метода уже сделана в классе yii\db\Query.
     * Тип возвращаемого значения не указан для совместимости с родителем.
     *
     * @param string|array|Expression $tables Таблица или список таблиц из которых нужно выбрать данные.
     *
     * @return QueryInterface|mixed
     */
    public function from($tables);

    /**
     * Метод устанавливает SELECT-часть формируемого запроса.
     * Метод добавлен в интерфейс, так как отсутствует в родительском интерфейсе.
     * Тем не менее, реализация метода уже сделана в классе yii\db\Query.
     * Тип возвращаемого значения не указан для совместимости с родителем.
     *
     * @param string|array|Expression $columns Столбцы, которые должны быть выбраны.
     * @param string|null             $option  Дополнительные опции выборки.
     *
     * @return QueryInterface|mixed
     */
    public function select($columns, $option = 'null');

    /**
     * Устанавливает сортировку результатов запроса.
     *
     * @param string $fieldName Название атрибута, по которому производится сортировка.
     * @param string $sortType  Тип сортировки - ASC или DESC.
     *
     * @return QueryInterface
     */
    public function sortBy(string $fieldName, string $sortType = 'DESC'): QueryInterface;
}
