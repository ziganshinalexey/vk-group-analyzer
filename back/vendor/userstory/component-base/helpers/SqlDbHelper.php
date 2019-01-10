<?php

namespace Userstory\ComponentBase\helpers;

use yii\db\ColumnSchema;
use yii\db\Connection;

/**
 * Класс SqlDbHelper.
 * Хелпер для работы с базой данных.
 *
 * @deprecated Следует использовать хелпер Userstory/Database/helpers/SchemaHelper из пакета userstory/database. Данный хелпер считается устаревшим.
 */
class SqlDbHelper
{
    /**
     * Метод проверяет, существует ли указанная таблица в базе.
     *
     * @param string     $tableName Таблица, существование которой нужно проверить.
     * @param Connection $db        Подключение к базе данных.
     *
     * @return boolean
     *
     * @deprecated Следует использовать метод Userstory/Database/helpers/SchemaHelper::isTableExist(...). Данный метод считается устаревшим.
     */
    public static function isTableExist($tableName, Connection $db)
    {
        if (null === $db->getTableSchema($tableName, true)) {
            return false;
        }
        return true;
    }

    /**
     * Метод проверяет, существует ли указанные столбец в указанной таблице.
     *
     * @param string     $tableName  Таблица, в которой ищется столбец.
     * @param string     $columnName Столбец, существование которого нужно проверить.
     * @param Connection $db         Подключение к базе данных.
     *
     * @return boolean
     *
     * @deprecated Следует использовать метод Userstory/Database/helpers/SchemaHelper::isColumnExist(...). Данный метод считается устаревшим.
     */
    public static function isColumnExist($tableName, $columnName, Connection $db)
    {
        if (null === $schema = $db->getTableSchema($tableName, true)) {
            return false;
        }
        if (! $schema->getColumn($columnName)) {
            return false;
        }
        return true;
    }

    /**
     * Метод получает столбец первичного ключа указанной таблицы.
     *
     * @param string     $tableName Таблица, для которой выполняется операция.
     * @param Connection $db        Подключение к базе данных.
     *
     * @return ColumnSchema
     *
     * @deprecated Следует использовать метод Userstory/Database/helpers/SchemaHelper::getSimplePrimaryKey(...). Данный метод считается устаревшим.
     */
    public static function getPkForTable($tableName, Connection $db)
    {
        $tableSchema = $db->getTableSchema($tableName, true);
        return $tableSchema->getColumn($tableSchema->primaryKey[0]);
    }
}
