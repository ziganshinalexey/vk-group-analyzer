<?php

use Userstory\ComponentMigration\models\db\AbstractMigration;
use Userstory\CompetingView\entities\CompetingView;

/**
 * Class m160622_084958_create_competing_table.
 * Класс миграции для модуля "Конкурентный просмотр".
 *
 * @package Userstory\CompetingView\migrations
 */
class m160622_084958_create_competing_table extends AbstractMigration
{
    /**
     * Конструктор инициализирует имена связанных таблиц.
     *
     * @param array $config массив конфигурации.
     */
    public function __construct(array $config)
    {
        $this->relationClass = CompetingView::class;
        parent::__construct($config);
    }

    /**
     * Безопасное (в транзакции) создание таблицы.
     *
     * @return void
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id'         => $this->primaryKey(),
            'entityName' => $this->string(255)->notNull()->comment('Имя сущности'),
            'entityId'   => $this->integer(10)->comment('ID сущности'),
            'userId'     => $this->integer()->notNull()->comment('ID пользователя'),
            'viewDate'   => $this->integer()->notNull()->comment('Время просмотра'),
        ], $this->getTableOptions(['comment' => 'Данные модуля Конкурентный просмотр']));

        $this->addIndex($this->tableName, [
            'entityName',
            'entityId',
            'userId',
        ], true);

        parent::safeUp();
    }
}
