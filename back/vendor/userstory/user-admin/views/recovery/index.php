<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\ModuleAdmin\widgets\ActiveForm\ActiveForm;
use Userstory\UserAdmin\forms\RecoveryForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var View $this */
/* @var ActiveForm $form */
/* @var RecoveryForm $model */

require_once __DIR__ . '/getAuth.php';

?>

<div class="row box box_white box_shadow">
    <div class="offset-l-1 offset-r-1">
        <?php
        $form = ActiveForm::begin([
            'action'      => Url::to('/recovery/option'),
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
        <div class="box">
            <h2 class="form__header">Восстановление пароля</h2>
        </div>
        <div class="box_justify">
            <?php
            echo Html::a('Авторизация', '/login', ['class' => 'link link_blue link_underlined box_justify__item']) . ' ';
            echo Html::a('Регистрация', '/register', ['class' => 'link link_blue link_underlined box_justify__item']); ?>
        </div>
        <?php
        echo $form->field($model, 'login')->textInput([
            'placeholder' => $model->getAttributeLabel('login'),
        ]); ?>
        <div class="form__group form__group_offset row">
            <div class="col-sm-6 col-sm-offset-3">
                <?php
                echo $form->submitButton('Отправить', [
                    'class' => ' form__field button button_style_primary button_size_normal',
                    'name'  => 'login-button',
                ]); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
