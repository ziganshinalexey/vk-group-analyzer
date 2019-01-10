<?php foreach ($foreignKeys as $column => $fkData) { ?>

        $this->createIndex(
            '<?= $fkData['idx']  ?>',
            '{{%<?= $table ?>}}',
            '<?= $column ?>'
        );

        $this->addForeignKey(
            '<?= $fkData['fk'] ?>',
            '{{%<?= $table ?>}}',
            '<?= $column ?>',
            '{{%<?= $fkData['relatedTable'] ?>}}',
            'id',
            'CASCADE'
        );
<?php }
