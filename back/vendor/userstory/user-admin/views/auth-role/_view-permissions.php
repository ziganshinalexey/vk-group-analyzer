<?php

use Userstory\UserAdmin\forms\PermissionForm;
use yii\helpers\Html;

/* @var PermissionForm[] $permissions */

?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Полномочие</th>
            <th>Глобально</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($permissions as $item) {
            echo Html::beginTag('tr');
            echo Html::tag('td', $item->description ?: $item->permission);
            echo Html::tag('td', $item->isGlobal ? 'Да' : 'Нет');
            echo Html::endTag('tr');
        } ?>
    </tbody>
</table>
