<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\ModuleMailer\entities\Mailer;

/**
 * Class m160505_081349_create_us_mailer. Таблица очереди рассылки.
 */
class m160505_081349_create_us_mailer extends AbstractMigration
{
    /**
     * Класс модели для миграции.
     *
     * @var string|null
     */
    protected $relationClass;

    /**
     * Инициализация, получаем имя таблицы.
     *
     * @return void
     */
    public function init()
    {
        $this->relationClass = Mailer::class;
        parent::init();
    }

    /**
     * Миграция создания таблицы.
     *
     * @return void
     */
    public function safeUp()
    {
        $tableOptions = $this->getTableOptions([]);

        $this->createTable($this->tableName, [
            'id'       => $this->primaryKey(),
            'to'       => $this->text(),
            'cc'       => $this->text(),
            'bcc'      => $this->text(),
            'subject'  => $this->string(),
            'message'  => $this->text(),
            'priority' => $this->integer(1),
        ], $tableOptions);

        $this->addCommentToTable($this->tableName, 'Очередь рассылки');
    }
}
