<?php

declare(strict_types = 1);

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Ziganshinalexey\Yii2VkApi\entities\UserActiveRecord;

/**
 * Класс реализует миграцию для создания основной таблицы пакета.
 */
class m190115_110052_create_user_table extends AbstractMigration
{
    /**
     * Имя класса сущности, связанного с миграцией.
     *
     * @var string
     */
    protected $relationClass = UserActiveRecord::class;

    /**
     * Данный метод создает таблицу и организует базовые связи.
     *
     * @return void
     */
    public function safeUp(): void
    {
        $this->createTable($this->tableName, [
            'id'             => $this->primaryKey()->comment('Идентификатор'),
            'firstName'      => $this->string(255)->null()->comment('Имя'),
            'lastName'       => $this->string(255)->null()->comment('Фамилия'),
            'universityName' => $this->string(255)->null()->comment('Университет'),
            'facultyName'    => $this->string(255)->null()->comment('Факультет'),
            'photo'          => $this->string(255)->null()->comment('Факультет'),
        ], $this->getTableOptions(['comment' => 'Пользователи']));
    }
}
