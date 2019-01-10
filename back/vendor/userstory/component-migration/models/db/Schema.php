<?php

namespace Userstory\ComponentMigration\models\db;

use yii\db\pgsql\Schema as pgSchema;

/**
 * Класс Schema.
 * Класс для извлечения метаданных из базы данных PostgreSQL.
 * Расширяет стандартный функционал.
 *
 * @package Userstory\ComponentMigration\models\db
 */
class Schema extends pgSchema
{
    /**
     * Метод создает экземпляр строителя схемы столбца.
     *
     * @param string $type   Тип данных столбца.
     * @param mixed  $length Точность данных столбца.
     *
     * @return ColumnSchemaBuilder
     */
    public function createColumnSchemaBuilder($type, $length = null)
    {
        return new ColumnSchemaBuilder($type, $length);
    }
}
