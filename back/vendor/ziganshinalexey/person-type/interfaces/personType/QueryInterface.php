<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\interfaces\personType;

use yii\db\Expression;
use yii\db\QueryInterface as YiiQueryInterface;

/**
 * Интерфейс опеределяет обертку для формирования критериев выборки данных.
 */
interface QueryInterface extends YiiQueryInterface
{
    /**
     * Выборка по атрибуту "Идентификатор" сущности "Тип личности".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности.
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byId(int $id, string $operator = '='): QueryInterface;

    /**
     * Задает критерий фильтрации по нескольким значениям атрибута "Идентификатор" сущности "Тип личности".
     *
     * @param array $ids Атрибут "Идентификатор" сущности "Тип личности".
     *
     * @return QueryInterface
     */
    public function byIds(array $ids): QueryInterface;

    /**
     * Выборка по атрибуту "Название" сущности "Тип личности".
     *
     * @param string $name     Атрибут "Название" сущности.
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byName(string $name, string $operator = '='): QueryInterface;

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
