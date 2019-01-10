<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\ModuleAdmin\widgets\ActiveForm\ActiveForm;
use Userstory\UserAdmin\forms\LoginForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/* @var View $this */
/* @var ActiveForm $form */
/* @var LoginForm $model */

$this->title = 'Аутентификация';

$templateEnvelope = '{label}<div class="form-group has-feedback">
{input}<span class="glyphicon glyphicon-envelope form-control-feedback"></span></div>{error}';
$templateLock     = '{label}<div class="form-group has-feedback">
{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span></div>{error}';

?>


<div class="login-box">
    <h1 class="text-center"><?= Yii::$app->name ?></h1>
    <?php

    $form = ActiveForm::begin([
        'id'      => 'login-form',
        'options' => ['class' => 'login-box-body clearfix'],
    ]);

    echo Html::tag('p', Yii::t('ModuleUserProfile.Login', 'formSubTitle', [
        'defaultTranslation' => 'Sign in to start your session',
    ]), ['class' => 'text-center']);

    echo $form->field($model, 'login', [
        'template' => $templateEnvelope,
    ])->textInput(['placeholder' => $model->getAttributeLabel('email')])->label(false);

    echo $form->field($model, 'password', [
        'template' => $templateLock,
    ])->passwordInput([
        'placeholder'  => $model->getAttributeLabel('password'),
        'autocomplete' => 'off',
    ])->label(false);

    if ($model->isRequireCaptcha()) {
        echo $form->field($model, 'captcha', ['enableClientValidation' => false])->widget(Captcha::class, ['captchaAction' => 'login/captcha']);
    }

    ?>

    <div class="row">
        <div class="col-xs-8">
            <?php
            echo $form->field($model, 'rememberMe', [
                'template' => '<div class="checkbox">{input}</div>',
            ])->checkbox()->label(false);
            ?>
        </div>
    </div>


    <?php
    echo $form->submitButton(Yii::t('ModuleUserProfile.Login', 'btnSignIn', [
        'defaultTranslation' => 'Sign in',
    ]), ['class' => 'btn btn-primary btn-flat pull-right']);
    ActiveForm::end();
    ?>
</div>

