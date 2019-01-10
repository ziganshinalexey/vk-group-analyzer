<?php

namespace Userstory\ComponentMigration\models\db;

use yii\db\ColumnSchemaBuilder as YiiSchemaBuilder;

/**
 * Класс ColumnSchemaBuilder.
 * Расширение функционала стандартного класса ColumnSchemaBuilder.
 *
 * @package Userstory\ComponentMigration\models\db
 */
class ColumnSchemaBuilder extends YiiSchemaBuilder
{
    /**
     * Метод возвращает категорию типа данных столбца.
     * В отличие от родительского метода, если тип данных не присутствует в карте категорий, вернет категорию "Другое".
     *
     * @return string
     */
    protected function getTypeCategory()
    {
        if (! array_key_exists($this->type, $this->categoryMap)) {
            return self::CATEGORY_OTHER;
        }
        return parent::getTypeCategory();
    }
}
