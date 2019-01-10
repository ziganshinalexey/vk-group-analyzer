<?php foreach ($fields as $field) { ?>
    $this->addColumn('{{%<?= $table ?>}}', '<?= $field['property'] ?>', $this-><?= $field['decorators'] ?>);
<?php }

echo $this->render(
    '_add_foreign_keys',
    [
        'table'       => $table,
        'foreignKeys' => $foreignKeys,
    ]
);
