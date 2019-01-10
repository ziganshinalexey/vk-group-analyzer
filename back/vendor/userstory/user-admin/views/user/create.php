<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\User\entities\UserProfileActiveRecord;

/* @var View  $this */
/* @var UserProfileActiveRecord $model*/

$this->title                   = 'Добавление пользователя';
$this->params['breadcrumbs'][] = [
    'label' => 'Пользователи',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-create">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
