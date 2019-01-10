<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\ModuleAdmin\widgets\ActiveForm\ActiveForm;
use Userstory\User\entities\AuthAssignmentActiveRecord;

/* @var View $this */
/* @var AuthAssignmentActiveRecord $model */
/* @var ActiveForm $form */

?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin();

    echo $form->field($model, 'roleId')->textInput();
    echo $form->field($model, 'profileId')->textInput();
    echo $form->field($model, 'isActive')->textInput();
    ?>
    <div class="form-group">
        <?=
        $form->submitButton($model->isNewRecord ? 'Create' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
