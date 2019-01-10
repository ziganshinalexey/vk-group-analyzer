<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\ModuleAdmin\widgets\ActiveForm\ActiveForm;
use Userstory\UserAdmin\forms\RoleForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var View $this */
/* @var RoleForm $model */
/* @var ActiveForm $form */

?>

<div class="auth-role-form">

    <?php
    $form = ActiveForm::begin([
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

    <div class="nav-tabs-custom flat no-margin">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#role-general" data-toggle="tab" aria-expanded="true">Основная информация</a></li>
            <li class=""><a href="#role-permissions" data-toggle="tab" aria-expanded="false">Полномочия</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="role-general">
                <?php
                echo $form->field($model, 'name')->textInput(['maxlength' => true]);
                echo $form->field($model, 'description')->textarea(['rows' => 6]); ?>
            </div>
            <div class="tab-pane" id="role-permissions">
                <?=
                $this->render('_form-permissions', [
                    'form'        => $form,
                    'permissions' => $model->permissions,
                ]) ?>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?php
        echo Html::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-flat btn-success margin-r-5']) . ' ';
        echo Html::a('Отмена', Url::to('index'), ['class' => 'btn btn-flat btn-default j-btn-back']); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>