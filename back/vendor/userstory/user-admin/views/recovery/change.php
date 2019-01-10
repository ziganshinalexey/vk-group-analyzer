<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\ModuleAdmin\widgets\ActiveForm\ActiveForm;
use Userstory\UserAdmin\forms\RecoveryForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var View $this */
/* @var ActiveForm $form */
/* @var RecoveryForm $model */

$this->title                   = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;

$template = '<div class="text-field form__field-wrapper">{input}</div>
<div class="form__error form__error_tooltip us-tooltip us-tooltip_error box box_shadow">{error}</div>';

echo $this->render('_token'); ?>

<div class="row box box_white box_shadow">
    <div class="offset-l-1 offset-r-1">
        <?php
        $form = ActiveForm::begin([
            'action'      => Url::to('/recovery/change'),
            'id'          => 'login-form',
            'options'     => [
                'class' => 'login-form form form_offset col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-2',
            ],
            'fieldConfig' => [
                'template'     => $template,
                'options'      => [
                    'class' => 'form__group',
                ],
                'inputOptions' => [
                    'class' => 'text-field__input form__field ',
                ],
            ],
        ]); ?>
        <div class="box_justify">
            <h2 class="form__header box_justify__item">Смена пароля</h2>
            <?= Html::a('Регистрация', '/register', ['class' => 'link link_blue link_underlined box_justify__item']); ?>
        </div>
        <?php
        if ($model->recoverySend) { ?>
            <div>
                На указанный
                <?php
                if ($model->typeVerificationEmail === (int)$model->recoverySend) {
                    echo 'email';
                }
                if ($model->typeVerificationSms === (int)$model->recoverySend) {
                    echo 'номер телефона';
                } ?>
                был отправлен код для восстановления пароля.
            </div>
            <?php
        }
        if (null === $model->recoveryCode) {
            echo $form->field($model, 'recoveryCode')->textInput(['placeholder' => $model->getAttributeLabel('recoveryCode')]);
        } else {
            echo $form->field($model, 'recoveryCode', [
                'options' => [
                    'class' => 'hidden',
                ],
            ])->hiddenInput();
        } ?>
        <div class="row">
            <div class="col-xs-6">
                <?php
                echo $form->field($model, 'password')->passwordInput([
                    'placeholder' => $model->getAttributeLabel('password'),
                ]); ?>
            </div>
            <div class="col-xs-6">
                <?php
                echo $form->field($model, 'passwordConfirm')->passwordInput([
                    'placeholder' => $model->getAttributeLabel('passwordConfirm'),
                ]); ?>
            </div>
        </div>
        <div class="form__group form__group_offset row">
            <div class="col-sm-6 col-sm-offset-3">
                <?php
                echo $form->submitButton('сохранить', [
                    'class' => ' form__field button button_style_primary button_size_normal',
                    'name'  => 'login-button',
                ]); ?>
            </div>
        </div>
        <?php
        ActiveForm::end(); ?>
    </div>
</div>