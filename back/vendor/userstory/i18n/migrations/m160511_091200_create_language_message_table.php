<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\I18n\entities\MessageActiveRecord;
use Userstory\I18n\entities\SourceMessageActiveRecord;
use Userstory\I18n\traits\LanguageMigrationTrait;

/**
 * Данный класс реализует миграцию для создания таблицы с переводами сообщений.
 */
class m160511_091200_create_language_message_table extends AbstractMigration
{
    use LanguageMigrationTrait;

    /**
     * Имя класса, связанного с миграцией.
     *
     * @var string
     */
    protected $relationClass = MessageActiveRecord::class;

    /**
     * Данный метод создает таблицу и организует связи.
     *
     * @return void
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id'          => $this->integer()->notNull()->comment('Идентификатор перевода'),
            'languageId'  => $this->integer()->notNull()->comment('Язык перевода'),
            'translation' => $this->text()->comment('Текст перевода'),
            'creatorId'   => $this->integer()->comment('Создатель'),
            'createDate'  => $this->dateTimeWithTZ()->notNull()->defaultExpression('now()')->comment('Время создания'),
            'updaterId'   => $this->integer()->comment('Редактор'),
            'updateDate'  => $this->dateTimeWithTZ()->comment('Время редактирования'),
        ], $this->getTableOptions(['comment' => 'Список языковых переводов.']));

        $this->addPrimaryKeyWithSuffix($this->tableName, [
            'id',
            'languageId',
        ]);
        $this->addForeignKeyForModifiers($this->tableName);
        $this->addForeignKeyWithSuffix($this->tableName, 'id', SourceMessageActiveRecord::tableName(), 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKeyForLanguage($this->tableName, 'languageId');
    }
}
