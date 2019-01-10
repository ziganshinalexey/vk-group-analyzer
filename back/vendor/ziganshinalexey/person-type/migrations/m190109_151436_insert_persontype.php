<?php

declare(strict_types = 1);

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Ziganshinalexey\PersonType\entities\PersonTypeActiveRecord;

/**
 * Класс реализует миграцию для создания основной таблицы пакета.
 */
class m190109_151436_insert_persontype extends AbstractMigration
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
        $this->insert($this->tableName, [
            'name' => 'Гуманитарий',
        ]);

        $this->insert($this->tableName, [
            'name' => 'Технарь',
        ]);
    }
}
