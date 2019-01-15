<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user;

use yii\db\Expression;
use yii\db\QueryInterface as YiiQueryInterface;

/**
 * Интерфейс опеределяет обертку для формирования критериев выборки данных.
 */
interface QueryInterface extends YiiQueryInterface
{
    /**
     * Выборка по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $facultyName Атрибут "Факультет" сущности.
     * @param string $operator    Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byFacultyName(string $facultyName, string $operator = '='): QueryInterface;

    /**
     * Выборка по атрибуту "Имя" сущности "ВК пользователь".
     *
     * @param string $firstName Атрибут "Имя" сущности.
     * @param string $operator  Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byFirstName(string $firstName, string $operator = '='): QueryInterface;

    /**
     * Выборка по атрибуту "Идентификатор" сущности "ВК пользователь".
     *
     * @param int    $id       Атрибут "Идентификатор" сущности.
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byId(int $id, string $operator = '='): QueryInterface;

    /**
     * Задает критерий фильтрации по нескольким значениям атрибута "Идентификатор" сущности "ВК пользователь".
     *
     * @param array $ids Атрибут "Идентификатор" сущности "ВК пользователь".
     *
     * @return QueryInterface
     */
    public function byIds(array $ids): QueryInterface;

    /**
     * Выборка по атрибуту "Фамилия" сущности "ВК пользователь".
     *
     * @param string $lastName Атрибут "Фамилия" сущности.
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byLastName(string $lastName, string $operator = '='): QueryInterface;

    /**
     * Выборка по атрибуту "Факультет" сущности "ВК пользователь".
     *
     * @param string $photo    Атрибут "Факультет" сущности.
     * @param string $operator Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byPhoto(string $photo, string $operator = '='): QueryInterface;

    /**
     * Выборка по атрибуту "Университет" сущности "ВК пользователь".
     *
     * @param string $universityName Атрибут "Университет" сущности.
     * @param string $operator       Оператор сравнения при поиске.
     *
     * @return QueryInterface
     */
    public function byUniversityName(string $universityName, string $operator = '='): QueryInterface;

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
