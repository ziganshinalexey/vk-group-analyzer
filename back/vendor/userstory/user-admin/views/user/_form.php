<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\ModuleAdmin\widgets\ActiveForm\ActiveForm;
use Userstory\UserAdmin\forms\UserProfileForm;
use yii\helpers\Html;

/* @var View $this */
/* @var UserProfileForm $model */
/* @var ActiveForm $form */
?>

<div class="user-form">
<?php $form = ActiveForm::begin([
    'options'     => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template'     => '
                {label}
                <div class="col-md-9">{input}{error}</div>

            ',
        'labelOptions' => ['class' => 'col-md-3 control-label'],
        'inputOptions' => ['class' => 'form-control'],
    ],
]); ?>
    <div class="box">
        <div class="box-body">
            <h3 class="box-title">Личные данные</h3>

            <?php
                echo $form->field($model, 'lastName')->textInput();
                echo $form->field($model, 'firstName')->textInput();
                echo $form->field($model, 'secondName')->textInput();
                echo $form->field($model, 'email')->textInput();
                echo $form->field($model, 'phone')->textInput(); ?>
            <div class="form-group"> <!--TODO придумать-->
                <div class="col-md-offset-3 col-md-9">
                    <div class="checkbox">
                        <?= Html::activeCheckbox($model, 'isActive') ?>
                    </div>
                </div>
            </div>

            <h3 class="box-title">Аутентификация</h3>

            <?php
                foreach ($model->getAuthForms() as $authID => $authForm) {
                    echo $form->field($authForm, '[' . $authID . ']login')->textInput();
                    echo $form->field($authForm, '[' . $authID . ']password')->passwordInput();
                    echo $form->field($authForm, '[' . $authID . ']confirmPassword', ['enableClientValidation' => false])->passwordInput();
                }
            ?>

            <h3 class="box-title">Роли</h3>

            <div class="form-group"> <!--TODO придумать-->
                <div class="col-md-offset-3 col-md-9">
                    <div class="checkbox">

                        <?php

                        foreach ($model->assignments as $assignment) {
                            echo $form->field($assignment, '[' . $assignment->roleId . ']isActive')->checkbox([
                                'class' => 'j-icheck',
                                'label' => $assignment->role->description,
                            ]);
                        }

                        ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <?php
            echo $form->submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', [
                'class' => 'btn btn-success',
            ])
            ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
