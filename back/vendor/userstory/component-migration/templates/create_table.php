<?php

echo "<?php\n";
?>

use Userstory\ComponentMigration\models\db\AbstractMigration;

/**
 * Class <?= $className ?>.
 * ### Тут необходимо описать что конкретно делает миграция. ###
 */
class <?= $className ?> extends AbstractMigration
{
    /**
     * Безопасная (в транзакции) инициализация.
     *
     * @return void
     */
    public function safeUp()
    {
    <?= $this->render('_create_table',
        [
            'table'       => $table,
            'fields'      => $fields,
            'foreignKeys' => $foreignKeys,
        ])
    ?>
    }

    /**
     * Безопасный метод деинициализации.
     *
     * @return void
     */
    public function safeDown()
    {
    <?= $this->render('_drop_table',
        [
            'table'       => $table,
            'foreignKeys' => $foreignKeys,
        ])
    ?>
    }
}
