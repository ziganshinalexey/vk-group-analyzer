<?php

/*
 * This view is used by console/controllers/MigrateCommand.php
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name */

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
    <?= $this->render('_drop_table',
        [
            'table'       => $table,
            'foreignKeys' => $foreignKeys,
        ]
    )
    ?>
    }

    /**
     * Безопасный метод деинициализации.
     *
     * @return void
     */
    public function safeDown()
    {
    <?= $this->render('_create_table',
        [
            'table'       => $table,
            'fields'      => $fields,
            'foreignKeys' => $foreignKeys,
        ]
    )
    ?>
    }
}
