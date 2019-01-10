<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\ModuleMailer\entities\Mailer;

/**
 * Class m170404_133209_update_mailer_table.
 * Класс миграции для внесение изменений в таблицу мейлера.
 */
class m170404_133209_update_mailer_table extends AbstractMigration
{
    /**
     * Конструктор класса миграции.
     *
     * @param array $config Конфигурация.
     */
    public function __construct(array $config)
    {
        $this->relationClass = Mailer::class;
        parent::__construct($config);
    }

    /**
     * Безопасная (в транзакции) инициализация.
     *
     * @return void
     */
    public function safeUp()
    {
        $this->alterColumn($this->tableName, 'message', $this->mediumText());
    }

    /**
     * Безопасный метод деинициализации.
     *
     * @return void
     */
    public function safeDown()
    {
        $this->alterColumn($this->tableName, 'message', 'TEXT');
    }
}
