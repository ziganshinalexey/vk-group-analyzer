<?php

declare(strict_types = 1);

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Ziganshinalexey\Keyword\entities\KeywordActiveRecord;

/**
 * Класс реализует миграцию для создания основной таблицы пакета.
 */
class m190110_132042_create_keyword_table extends AbstractMigration
{
    /**
     * Имя класса сущности, связанного с миграцией.
     *
     * @var string
     */
    protected $relationClass = KeywordActiveRecord::class;

    /**
     * Данный метод создает таблицу и организует базовые связи.
     *
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable($this->tableName, [
            'id'               => $this->primaryKey()->comment('Идентификатор'),
            'text'             => $this->text()->notNull()->comment('Название'),
            'ratio'            => $this->integer()->notNull()->defaultValue('1')->comment('Коэффициент'),
            'coincidenceCount' => $this->integer()->notNull()->defaultValue('1')->comment('Количество совпадений'),
            'personTypeId'     => $this->integer()->null()->comment('Идентификатор типа личности'),
        ], $this->getTableOptions(['comment' => 'Ключевые фразы']));
    }
}
