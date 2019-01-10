<?php

declare(strict_types = 1);

namespace Userstory\Database\interfaces\queries\sql;

use Userstory\ComponentBase\interfaces\PrototypeInterface;
use yii\db\Command;
use yii\db\QueryInterface;

/**
 * Интерфейс BaseSqlQueryInterface.
 * Базовый интерфейс объекта SQL запроса к базе данных.
 * Интерфейс содержит методы стандартного уевого объекта SQL запроса.
 */
interface BaseQueryInterface extends QueryInterface, PrototypeInterface
{
    /**
     * Метод возвращает команду базы данных.
     *
     * @param mixed $db Объект подключения к базе данных.
     *
     * @return Command
     */
    public function createCommand($db = null);

    /**
     * Метод устанавливает филтр получаемых данных запроса.
     *
     * @param mixed $columns Список столбцов, данные которых нужно получить.
     * @param mixed $option  Дполнительные опции.
     *
     * @return static
     */
    public function select($columns, $option = null);

    /**
     * Метод дополняет фильтр получаемых данных.
     *
     * @param mixed $columns Список столбцов, данные которых нужно получить.
     *
     * @return static
     */
    public function addSelect($columns);

    /**
     * Метод устанавливает название таблицы, для которой выполняется запроса.
     *
     * @param mixed $tables Название таблицы.
     *
     * @return static
     */
    public function from($tables);

    /**
     * Метод добавляет иннер джоин с другой таблицей.
     *
     * @param mixed $table  Таблица для джоина.
     * @param mixed $on     Условия для ждоина.
     * @param mixed $params Параметры для джоина.
     *
     * @return static
     */
    public function innerJoin($table, $on = '', $params = []);

    /**
     * Метод добавляет лефт джоин с другой таблицей.
     *
     * @param mixed $table  Таблица для джоина.
     * @param mixed $on     Условия для ждоина.
     * @param mixed $params Параметры для джоина.
     *
     * @return static
     */
    public function leftJoin($table, $on = '', $params = []);

    /**
     * Метод добавляет райт джоин с другой таблицей.
     *
     * @param mixed $table  Таблица для джоина.
     * @param mixed $on     Условия для ждоина.
     * @param mixed $params Параметры для джоина.
     *
     * @return static
     */
    public function rightJoin($table, $on = '', $params = []);

    /**
     * Метод устанавливает группировку данных.
     *
     * @param mixed $columns Столбцы, по которым необходимо выполнить группировку.
     *
     * @return static
     */
    public function groupBy($columns);

    /**
     * Метод добавляет группировку данных.
     *
     * @param mixed $columns Столбцы, по которым необходимо выполнить группировку.
     *
     * @return static
     */
    public function addGroupBy($columns);

    /**
     * Метод добавляет параметры к запросу.
     *
     * @param mixed $params Параметры запроса.
     *
     * @return static
     */
    public function addParams($params);
}
