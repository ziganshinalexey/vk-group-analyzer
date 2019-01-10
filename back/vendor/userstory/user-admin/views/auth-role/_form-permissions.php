<?php

use Userstory\ModuleAdmin\widgets\ActiveForm\ActiveForm;
use Userstory\UserAdmin\forms\PermissionForm;
use yii\helpers\Html;

/* @var PermissionForm[] $permissions */
/* @var ActiveForm $form */

?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Полномочие</th>
            <th>Разрешено</th>
            <th>Глобально</th>
        </tr>
    </thead>
    <tbody>
        <?php

        foreach ($permissions as $index => $item) {
            echo Html::tag('td', $item->description);

            $assigned = $form->field($item, '[' . $index . ']isAssigned')->checkbox([
                'class' => 'j-icheck',
            ], false)->label(false);

            echo Html::tag('td', $assigned, ['class' => 'text-center']);

            $global = $form->field($item, '[' . $index . ']isGlobal')->checkbox([
                'class' => 'j-icheck',
            ], false)->label(false);

            echo Html::tag('td', $global, ['class' => 'text-center']);

            echo '</tr>';
        }

        ?>
    </tbody>
</table>