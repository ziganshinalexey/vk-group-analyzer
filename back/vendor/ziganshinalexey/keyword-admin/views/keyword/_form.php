<?php

declare(strict_types = 1);

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\ModuleAdmin\widgets\ActiveForm\ActiveForm;
use Ziganshinalexey\KeywordAdmin\forms\keyword\UpdateForm;

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
            <br />
            <?php
            /* @var UpdateForm $model */
            echo $form->field($model, 'text')->textInput([
                'maxlength' => true,
            ]);
            echo $form->field($model, 'ratio')->textInput([
                'maxlength' => true,
            ]);
            echo $form->field($model, 'coincidenceCount')->textInput([
                'maxlength' => true,
            ]);
            echo $form->field($model, 'personTypeId')->dropDownList(ArrayHelper::map($personTypeList, 'id', 'name'));
            ?>
        </div>

        <div class="box-footer">
            <?php
            echo $form->submitButton(Yii::t('Admin.Keyword.Keyword', 'saveKeyword', 'Сохранить'), [
                'class' => 'btn btn-primary',
            ])
            ?>
        </div>
    </div>
</div>

<?php
ActiveForm::end();
?>
