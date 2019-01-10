<?php foreach ($foreignKeys as $fkData) { ?>
        $this->dropForeignKey(
            '<?= $fkData['fk'] ?>',
            '<?= $table ?>'
        );

        $this->dropIndex(
            '<?= $fkData['idx'] ?>',
            '<?= $table ?>'
        );

<?php }
