<?php

namespace Userstory\ComponentBase\traits;

/**
 * Trait TableSchemaCacheTrait.
 * Трейт для кэширования схемы таблицы на уровне памяти (для оптимизации кэша).
 *
 * @deprecated Следует использовать Userstory\Yii2Cache.
 */
trait TableSchemaCacheTrait
{
    /**
     * Сохраненная схема таблицы.
     *
     * @var mixed|null
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     */
    protected static $schemaCache;

    /**
     * Сохраненный список допустимых атрибутов класса.
     *
     * @var mixed|null
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     */
    protected static $attributesCache;

    /**
     * Переопределенный метод запроса схемы таблицы.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     *
     * @return mixed
     */
    public static function getTableSchema()
    {
        if (! isset(static::$schemaCache)) {
            static::$schemaCache = parent::getTableSchema();
        }

        return static::$schemaCache;
    }

    /**
     * Переопределенный метод возвращает список всех атрибутов модели с использованием кэширования.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache.
     *
     * @return mixed|null
     */
    public function attributes()
    {
        if (! isset(static::$attributesCache)) {
            static::$attributesCache = parent::attributes();
        }

        return static::$attributesCache;
    }
}
