<?php

namespace Userstory\Database\helpers;

use Userstory\Database\exceptions\BaseDatabaseException;
use Userstory\Database\exceptions\NoSimplePKForTableException;
use Userstory\Database\exceptions\WrongConnectionException;
use yii\db\TableSchema;
use yii\db\ColumnSchema;
use yii\db\Connection;
use yii;

/**
 * Класс SchemaHelper.
 * Хелпер для работы со схемой базы данных.
 */
class SchemaHelper
{
    /**
     * Метод возвращает подключение к базе данных по умолчанию если передано пустое подключение.
     * Иначе возвращается переданное подключение.
     *
     * @param Connection|null $db Заданное значение подключения.
     *
     * @return Connection
     *
     * @throws WrongConnectionException Исключение генерируется в случае если объект подключения сконфигурирован неверно.
     */
    protected static function setConnectionIfEmpty(Connection $db = null)
    {
        if ($db) {
            return $db;
        }
        $result = Yii::$app->db;
        if (! $result instanceof Connection) {
            throw new WrongConnectionException('Connection object must be instance of ' . Connection::class);
        }
        return $result;
    }

    /**
     * Метод проверяет, существует ли указанная таблица в базе.
     *
     * @param string          $tableName Таблица, существование которой нужно проверить.
     * @param Connection|null $db        Подключение к базе данных. Если не указано - используется подключение по умолчанию.
     *
     * @return boolean
     */
    public static function isTableExist($tableName, Connection $db = null)
    {
        $db = static::setConnectionIfEmpty($db);
        return ! ( null === $db->getTableSchema($tableName, true) );
    }

    /**
     * Метод проверяет, существует ли указанные столбец в указанной таблице.
     *
     * @param string          $tableName  Таблица, в которой ищется столбец.
     * @param string          $columnName Столбец, существование которого нужно проверить.
     * @param Connection|null $db         Подключение к базе данных. Если не указано - используется подключение по умолчанию.
     *
     * @return boolean
     */
    public static function isColumnExist($tableName, $columnName, Connection $db = null)
    {
        $db = static::setConnectionIfEmpty($db);
        if (null === $schema = $db->getTableSchema($tableName, true)) {
            return false;
        }
        if (! $schema->getColumn($columnName)) {
            return false;
        }
        return true;
    }

    /**
     * Метод получает простой первичный ключ указанной таблицы.
     *
     * @param string          $tableName Таблица, для которой выполняется операция.
     * @param Connection|null $db        Подключение к базе данных. Если не указано - используется подключение по умолчанию.
     *
     * @return ColumnSchema
     *
     * @throws BaseDatabaseException Исключение генерируется в случае возникновения непредвиденных ошибок.
     * @throws NoSimplePKForTableException Исключение генерируется в случае если у таблицы нет простого первичнго ключа.
     */
    public static function getSimplePrimaryKey($tableName, Connection $db = null)
    {
        $db          = static::setConnectionIfEmpty($db);
        $tableSchema = $db->getTableSchema($tableName, true);
        if (! is_array($tableSchema->primaryKey)) {
            throw new BaseDatabaseException('Wrong ' . TableSchema::class . '::primaryKey format');
        }
        if (count($tableSchema->primaryKey) !== 1) {
            throw new NoSimplePKForTableException('The table "' . $tableName . '" does not have a simple primary key');
        }
        $surrogateKeyColumnName = array_values($tableSchema->primaryKey)[0];
        return $tableSchema->getColumn($surrogateKeyColumnName);
    }
}
