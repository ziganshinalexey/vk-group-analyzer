<?php

use Userstory\ComponentFieldset\entities\Fieldset;
use Userstory\ComponentFieldset\entities\FieldSetting;
use Userstory\ComponentMigration\models\db\AbstractMigration;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;

/**
 * Class m160330_173100_fieldset_init.
 * Миграция, инициализирующая работу с динамическими формами.
 */
class m160330_173101_create_table_fieldset_settings extends AbstractMigration
{
    /**
     * Наименование таблицы для настроек филдсетов.
     *
     * @var null|string
     */
    protected $fieldsetTable;

    /**
     * Конструктор, происзводит первичную инициализацию.
     *
     * @param array $config Параметры инициализации.
     *
     * @return m160330_173101_create_table_fieldset_settings
     */
    public function __construct(array $config)
    {
        $this->relationClass = FieldSetting::class;
        $this->fieldsetTable = Fieldset::tableName();
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
        // Настройки полей формы.
        $this->createTable($this->tableName, [
            'id'          => $this->primaryKey(),
            'fieldsetId'  => $this->integer()->notNull(),
            'name'        => $this->string(50)->notNull(),
            'label'       => $this->string(255),
            'description' => $this->text(),
            'rulesJson'   => 'JSON NULL',
            'isPublic'    => $this->smallInteger(1)->defaultValue(1),
            'creatorId'   => $this->integer(),
            'createDate'  => $this->dateTimeWithTZ()->notNull()->defaultExpression('NOW()'),
            'updaterId'   => $this->integer(),
            'updateDate'  => $this->dateTimeWithTZ(),
        ], $this->getTableOptions(['COMMENT' => 'Таблица настроек полей для fieldset.']));

        $this->addForeignKeyForModifiers($this->tableName);

        $this->addIndex($this->tableName, [
            'fieldsetId',
            'name',
        ]);

        $this->addForeignKeyWithSuffix($this->tableName, 'fieldsetId', $this->fieldsetTable, 'id', 'CASCADE', 'CASCADE');
    }
}
