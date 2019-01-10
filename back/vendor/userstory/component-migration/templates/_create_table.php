    $this->createTable('{{%<?= $table ?>}}', [
<?php foreach ($fields as $field) {
    if (empty($field['decorators'])) {
        echo '            \'' . $field['property'] . '\',';
    }
    echo '            \'' . $field['property'] . '\' => $this->' . $field['decorators'] ?>,
<?php }
?>
        ]);
<?= $this->render(
    '_add_foreign_keys',
    [
        'table'       => $table,
        'foreignKeys' => $foreignKeys,
    ]
);
