<?php

echo $this->render(
    '_drop_foreign_keys',
    [
        'table'       => $table,
        'foreignKeys' => $foreignKeys,
    ]
) ?>
    $this->dropTable('{{%<?= $table ?>}}');
