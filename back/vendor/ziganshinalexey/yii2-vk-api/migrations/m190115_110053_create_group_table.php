<?php

declare(strict_types = 1);

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Ziganshinalexey\Yii2VkApi\entities\GroupActiveRecord;

/**
 * Класс реализует миграцию для создания основной таблицы пакета.
 */
class m190115_110053_create_group_table extends AbstractMigration
{
    /**
     * Имя класса сущности, связанного с миграцией.
     *
     * @var string
     */
    protected $relationClass = GroupActiveRecord::class;

    /**
     * Данный метод создает таблицу и организует базовые связи.
     *
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable($this->tableName, [
            'id'          => $this->primaryKey()->comment('Идентификатор'),
            'name'        => $this->string(255)->null()->comment('Название'),
            'activity'    => $this->string(255)->null()->comment('Название'),
            'description' => $this->text()->null()->comment('Название'),
        ], $this->getTableOptions(['comment' => 'Группа']));
    }
}
