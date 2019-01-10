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
    }

    /**
     * Безопасный метод деинициализации.
     *
     * @return void
     */
    public function safeDown()
    {
    }
}
