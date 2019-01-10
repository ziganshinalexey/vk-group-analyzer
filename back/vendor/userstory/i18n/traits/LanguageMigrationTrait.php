<?php

namespace Userstory\I18n\traits;

use Userstory\I18n\entities\LanguageActiveRecord;

/**
 * Трэит LanguageMigrationTrait Для работы я зыками в миграциях.
 *
 * @package Userstory\I18n\traits
 */
trait LanguageMigrationTrait
{
    /**
     * Свойство содержит класс сущности языка.
     *
     * @var string
     */
    protected $languageClass = LanguageActiveRecord::class;

    /**
     * Метод возвращает имя таблица языка.
     *
     * @return string
     */
    public function getLanguageTableName()
    {
        $class = $this->languageClass;
        return $class::tableName();
    }

    /**
     * Метод создает внешний ключ указанной колонки с таблицей языков.
     *
     * @param string $tableName Название Таблицы.
     * @param string $field     Название колонки текущей таблицы для внешнего ключа.
     * @param string $onDelete  Событие при удалении родительской записи.
     * @param string $onUpdate  Событие при редактировании родительской записи.
     *
     * @return void
     */
    public function addForeignKeyForLanguage($tableName, $field = 'languageId', $onDelete = 'CASCADE', $onUpdate = 'CASCADE')
    {
        $this->addForeignKeyWithSuffix($tableName, $field, $this->getLanguageTableName(), 'id', $onDelete, $onUpdate);
    }
}
