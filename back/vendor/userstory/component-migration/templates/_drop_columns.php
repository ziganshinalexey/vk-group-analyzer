<?php

echo $this->render(
    '_drop_foreign_keys',
    [
        'table'       => $table,
        'foreignKeys' => $foreignKeys,
    ]
);

foreach ($fields as $field) { ?>
    $this->dropColumn('{{%<?= $table ?>}}', '<?= $field['property'] ?>');
<?php }
