<?php

declare(strict_types = 1);

use Userstory\ModuleAdmin\widgets\ActiveForm\ActiveForm;
use Ziganshinalexey\PersonTypeAdmin\forms\persontype\UpdateForm;

$form = ActiveForm::begin([
    'options'     => [
        'class' => 'form-horizontal',
    ],
    'fieldConfig' => [
        'template'     => '{label}<div class="col-md-9">{input}{error}</div>',
        'labelOptions' => ['class' => 'col-md-3 control-label'],
        'inputOptions' => ['class' => 'form-control'],
    ],
]);

?>

<div class="form">
    <div class="box">
        <div class="box-body">
            <?php
            /* @var UpdateForm $model */

            ?>
            <h3 class="box-title">
                <?= Yii::t('Admin.PersonType.PersonType', 'titleUpdate', 'Редактировать "Тип личности"'); ?>
            </h3>
            <?php
            echo $form->field($model, 'name')->textInput([
                'maxlength' => true,
            ]);
            ?>
        </div>

        <div class="box-footer">
            <?php
            echo $form->submitButton(Yii::t('Admin.PersonType.PersonType', 'savePersonType', 'Сохранить'), [
                'class' => 'btn btn-primary',
            ])
            ?>
        </div>
    </div>
</div>

<?php
ActiveForm::end();
?>
