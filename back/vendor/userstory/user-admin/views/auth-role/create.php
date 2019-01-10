<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\UserAdmin\forms\RoleForm;

/* @var View $this */
/* @var RoleForm $model */

$this->title                   = 'Добавление роли';
$this->params['breadcrumbs'][] = [
    'label' => 'Роли',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-role-create">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
