<?php

declare(strict_types = 1);

use Userstory\ComponentMigration\models\db\AbstractMigration;
use yii\base\InvalidCallException;
use Ziganshinalexey\Keyword\entities\KeywordActiveRecord;
use Ziganshinalexey\PersonType\entities\PersonTypeActiveRecord;

/**
 * Класс реализует миграцию для создания внешнего ключа.
 */
class m190109_151416_create_foreign_key_keyword_table_persontypeid extends AbstractMigration
{
    /**
     * Имя класса сущности, связанного с миграцией.
     *
     * @var string
     */
    protected $relationClass = KeywordActiveRecord::class;

    /**
     * Данный метод удалет созданный внешний ключ.
     *
     * @return void
     */
    public function safeDown(): void
    {
        $fkName = $this->addSuffix($this->tableName, '_' . implode('_', ['personTypeId']) . '_fk');
        $this->dropForeignKey($fkName, $this->tableName);
    }

    /**
     * Данный метод создает требуемый внешний ключ.
     *
     * @return void
     */
    public function safeUp(): void
    {
        $schemas = $this->db->schema->getTableSchema($this->tableName);
        if (null === $schemas) {
            throw new InvalidCallException('Table "' . $this->tableName . '" not exists');
        }
        $fkName = $this->addSuffix($this->tableName, '_' . implode('_', ['personTypeId']) . '_fk');

        parent::addForeignKey($fkName, $this->tableName, ['personTypeId'], PersonTypeActiveRecord::tableName(), ['id'], 'CASCADE', 'CASCADE');
    }
}
