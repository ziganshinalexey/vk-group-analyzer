<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\I18n\entities\SourceMessageActiveRecord;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;

/**
 * Данный класс реализует миграцию для создания таблицы с нуждающимися в переводе сообщениями.
 */
class m160511_091100_create_language_source_message_table extends AbstractMigration
{
    /**
     * Имя класса, связанного с миграцией.
     *
     * @var string
     */
    protected $relationClass = SourceMessageActiveRecord::class;

    /**
     * Данный метод создает таблицу и организует связи.
     *
     * @throws NotSupportedException Генерируется в родителе в случае, если нет поддержки для текущего типа драйвера.
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authenticationService не существует.
     *
     * @return void
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id'         => $this->primaryKey()->comment('Идентификатор блока преводов'),
            'category'   => $this->string(255)->comment('Категория для блока переводов'),
            'message'    => $this->text()->comment('Алиас для блока переводов'),
            'comment'    => $this->string(255)->comment('Комментарий к блоку переводов'),
            'creatorId'  => $this->integer()->comment('Создатель'),
            'createDate' => $this->dateTimeWithTZ()->notNull()->defaultExpression('now()')->comment('Время создания'),
            'updaterId'  => $this->integer()->comment('Редактор'),
            'updateDate' => $this->dateTimeWithTZ()->comment('Время редактирования'),
        ], $this->getTableOptions(['comment' => 'Список общих данных для блока переводов.']));

        $this->addForeignKeyForModifiers($this->tableName);
    }
}
