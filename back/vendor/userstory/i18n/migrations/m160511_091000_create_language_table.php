<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\I18n\entities\LanguageActiveRecord;

/**
 * Данный класс реализует миграцию для создания таблицы с поддерживаемыми системой языками.
 */
class m160511_091000_create_language_table extends AbstractMigration
{
    /**
     * Имя класса, связанного с миграцией.
     *
     * @var string
     */
    protected $relationClass = LanguageActiveRecord::class;

    /**
     * Данный метод создает таблицу и организует связи.
     *
     * @return void
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id'         => $this->primaryKey()->comment('Идентификатор языка'),
            'code'       => $this->string(3)->notNull()->unique()->comment('Код языка'),
            'name'       => $this->string(20)->notNull()->comment('Название языка'),
            'isDefault'  => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('Флаг языка по-умолчанию'),
            'isActive'   => $this->smallInteger(1)->notNull()->defaultValue(1)->comment('Флаг активного языка'),
            'url'        => $this->string(50)->comment('Урл языка'),
            'icon'       => $this->string(255)->comment('Название иконки языка'),
            'locale'     => $this->string(10)->comment('Локаль языка'),
            'creatorId'  => $this->integer()->comment('Создатель'),
            'createDate' => $this->dateTimeWithTZ()->notNull()->defaultExpression('now()')->comment('Время создания'),
            'updaterId'  => $this->integer()->comment('Редактор'),
            'updateDate' => $this->dateTimeWithTZ()->comment('Время редактирования'),
        ], $this->getTableOptions(['comment' => 'Список поддерживаемых языков системы']));

        $this->addForeignKeyForModifiers($this->tableName);

        $this->insert($this->tableName, [
            'code'      => 'rus',
            'name'      => 'Русский',
            'isDefault' => 1,
            'url'       => 'ru',
            'locale'    => 'ru_RU',
        ]);

        $this->insert($this->tableName, [
            'code'   => 'eng',
            'name'   => 'English',
            'url'    => 'en',
            'locale' => 'en_US',
        ]);
    }
}
