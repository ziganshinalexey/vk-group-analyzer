<?php

$this->title                   = 'Восстановление';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row box box_white box_shadow clearfix">
    <div class="offset-l-1 offset-r-1">
        <div class="content login-form form_offset col-sm-offset-1 col-md-offset-2 col-sm-10 col-md-8">
            <h2 class="form__header">Отличная работа!</h2>
            <p>Ваш пароль успешно изменен.</p>
            <p>Перейти на
                <a href="<?= Yii::$app->getUrlManager()->createAbsoluteUrl('/') ?>">главную страницу</a>
                или
                <a href="<?= Yii::$app->getUrlManager()->createAbsoluteUrl('/login') ?>">войти</a> с новым паролем</p>
        </div>
    </div>
</div>

