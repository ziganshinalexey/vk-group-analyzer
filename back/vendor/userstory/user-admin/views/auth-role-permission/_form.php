<?php

use Userstory\ModuleAdmin\widgets\ActiveForm\ActiveForm;
use Userstory\ModuleAdmin\components\View;
use Userstory\User\entities\AuthRolePermissionActiveRecord;

/* @var View $this*/
/* @var AuthRolePermissionActiveRecord $model */
/* @var ActiveForm $form */
?>

<div class="auth-role-permission-form">

    <?php $form = ActiveForm::begin();

    echo $form->field($model, 'roleId')->textInput();
    echo $form->field($model, 'permission')->textInput(['maxlength' => true]);
    echo $form->field($model, 'isGlobal')->textInput();
    ?>

    <div class="form-group">
        <?=
        $form->submitButton($model->isNewRecord ? 'Create' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
