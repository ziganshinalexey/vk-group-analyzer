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
            <h2 class="form__header box_justify__item">Восстановление</h2>
            <?= Html::a('Регистрация', '/register', ['class' => 'link link_blue link_underlined box_justify__item']); ?>
        </div>
        <?php
        echo $form->field($model, 'login')->hiddenInput(['value' => $model->user->login]);
        $radioItemOptions = [
            'class' => 'form__field',
            'item'  => function($index, $label, $name, $checked, $value) {
                $check = $checked ? ' checked="checked"' : '';
                return sprintf('<div class="radio-field">
                <input type="radio" id="%3$s%1$s" class="radio-field__input"
                       name="%3$s" value="%5$s" data-type="portal"%4$s>
                <label class="radio-field__label" for="%3$s%1$s">
                    <span>%2$s</span>
                </label>
            </div>', $index, $label, $name, $check, $value);
            },
        ];
        echo $form->field($model, 'recoverySend')->radioList($result['type'], $radioItemOptions); ?>
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