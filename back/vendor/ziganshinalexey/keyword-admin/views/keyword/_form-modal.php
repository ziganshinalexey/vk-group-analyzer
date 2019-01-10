<?php

declare(strict_types = 1);

use dosamigos\tinymce\TinyMce;
use Userstory\ModuleAdmin\widgets\ActiveForm\ActiveForm;
use yii\helpers\Html;
use Ziganshinalexey\KeywordAdmin\forms\keyword\CreateForm;

$form = ActiveForm::begin([
    'id'                   => 'form-keyword-create',
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
            <?= Yii::t('Admin.Keyword.Keyword', 'titleAddModal', 'Создать ключевую фразу"'); ?>
        </h4>
    </div>

    <div class="modal-body">
    <?php
    /* @var CreateForm $model */
    echo $form->field($model, 'text')->widget(TinyMce::class, [
        'options'  => [
            'rows' => 6,
        ],
        'language' => 'ru',
    ]);
    echo $form->field($model, 'ratio')->textInput([
        'maxlength' => true,
    ]);
    echo $form->field($model, 'coincidenceCount')->textInput([
        'maxlength' => true,
    ]);
    echo $form->field($model, 'personTypeId')->textInput([
        'maxlength' => true,
    ]);
    ?>
    </div>

    <div class="modal-footer">
    <?php
    echo $form->submitButton(Yii::t('Admin.Keyword.Keyword', 'addKeyword', 'Создать ключевую фразу"'), ['class' => 'btn btn-primary']);

    echo Html::a(Yii::t('Admin.Keyword.Keyword', 'closeAddModal', 'Закрыть'), ['keyword/index'], [
        'class'        => 'btn btn-default pull-left',
        'data-dismiss' => 'modal',
    ])
    ?>
    </div>
</div>
<?php
ActiveForm::end();
?>
