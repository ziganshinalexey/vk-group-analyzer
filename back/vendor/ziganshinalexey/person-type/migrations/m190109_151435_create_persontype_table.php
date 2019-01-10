<?php

declare(strict_types = 1);

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Ziganshinalexey\PersonType\entities\PersonTypeActiveRecord;

/**
 * Класс реализует миграцию для создания основной таблицы пакета.
 */
class m190109_151435_create_persontype_table extends AbstractMigration
{
    /**
     * Имя класса сущности, связанного с миграцией.
     *
     * @var string
     */
    protected $relationClass = PersonTypeActiveRecord::class;

    /**
     * Данный метод создает таблицу и организует базовые связи.
     *
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable($this->tableName, [
            'id'   => $this->primaryKey()->comment('Идентификатор'),
            'name' => $this->string(255)->notNull()->comment('Название'),
        ], $this->getTableOptions(['comment' => 'Типы личностей']));
    }
}
