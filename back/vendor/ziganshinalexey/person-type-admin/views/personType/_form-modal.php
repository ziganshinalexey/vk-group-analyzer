<?php

declare(strict_types = 1);

use Userstory\ModuleAdmin\widgets\ActiveForm\ActiveForm;
use yii\helpers\Html;
use Ziganshinalexey\PersonTypeAdmin\forms\persontype\CreateForm;

$form = ActiveForm::begin([
    'id'                   => 'form-personType-create',
    'enableAjaxValidation' => true,
    'validateOnSubmit'     => true,
    'validateOnChange'     => false,
    'validateOnBlur'       => false,
    'options'              => [
        'class'   => 'form-horizontal',
        'style'   => 'margin-left: 15px; margin-right: 15px;',
        'enctype' => 'multipart/form-data',
    ],
    'fieldConfig'          => [
        'template'     => '{label}<div class="col-md-9">{input}{error}</div>',
        'labelOptions' => ['class' => 'col-md-3 control-label'],
        'inputOptions' => ['class' => 'form-control'],
    ],
]);

?>

<div class="modal-form">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        
        <h4 class="modal-title">
            <?= Yii::t('Admin.PersonType.PersonType', 'titleAddModal', 'Создать "Тип личности"'); ?>
        </h4>
    </div>

    <div class="modal-body">
    <?php
    /* @var CreateForm $model */
    echo $form->field($model, 'name')->textInput([
        'maxlength' => true,
    ]);
    ?>
    </div>

    <div class="modal-footer">
    <?php
    echo $form->submitButton(Yii::t('Admin.PersonType.PersonType', 'addPersonType', 'Создать "Тип личности"'), ['class' => 'btn btn-primary']);

    echo Html::a(Yii::t('Admin.PersonType.PersonType', 'closeAddModal', 'Закрыть'), ['person-type/index'], [
        'class'        => 'btn btn-default pull-left',
        'data-dismiss' => 'modal',
    ])
    ?>
    </div>
</div>
<?php
ActiveForm::end();
?>
