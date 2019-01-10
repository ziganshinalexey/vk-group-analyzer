<?php

declare(strict_types = 1);

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Ziganshinalexey\Keyword\entities\KeywordActiveRecord;

/**
 * Класс реализует миграцию для создания основной таблицы пакета.
 */
class m190109_151415_create_keyword_table extends AbstractMigration
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
            'id'           => $this->primaryKey()->comment('Идентификатор'),
            'text'         => $this->text()->notNull()->comment('Название'),
            'personTypeId' => $this->integer()->notNull()->comment('Идентификатор типа личности'),
        ], $this->getTableOptions(['comment' => 'Ключевые фразы']));
    }
}
