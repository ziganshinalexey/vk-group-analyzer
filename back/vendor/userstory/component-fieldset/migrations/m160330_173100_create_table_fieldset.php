<?php

use Userstory\ComponentFieldset\entities\Fieldset;
use Userstory\ComponentMigration\models\db\AbstractMigration;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;

/**
 * Class m160330_173100_fieldset_init.
 * Миграция, инициализирующая работу с динамическими формами.
 */
class m160330_173100_create_table_fieldset extends AbstractMigration
{
    /**
     * Конструктор, происзводит первичную инициализацию.
     *
     * @param array $config Параметры инициализации.
     *
     * @return m160330_173100_create_table_fieldset
     */
    public function __construct(array $config)
    {
        $this->relationClass = Fieldset::class;
        parent::__construct($config);
    }

    /**
     * Безопасная (в транзакции) инициализация.
     *
     * @throws NotSupportedException Генерируется в родителе в случае, если нет поддержки для текущего типа драйвера.
     * @throws InvalidConfigException Генерируется в родителе в случае, компонент authenticationService не существует.
     *
     * @return void
     */
    public function safeUp()
    {
        // Таблица с формами.
        $this->createTable($this->tableName, [
            'id'          => $this->primaryKey(),
            'name'        => $this->string(50)->notNull()->unique(),
            'caption'     => $this->string(255)->notNull(),
            'description' => $this->text(),
            'canModified' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'creatorId'   => $this->integer(),
            'createDate'  => $this->dateTimeWithTZ()->notNull()->defaultExpression('NOW()'),
            'updaterId'   => $this->integer(),
            'updateDate'  => $this->dateTimeWithTZ(),
        ], $this->getTableOptions(['COMMENT' => 'Таблица для хранения расширяемых полей']));

        $this->addForeignKeyForModifiers($this->tableName);

        parent::safeUp();
    }
}
