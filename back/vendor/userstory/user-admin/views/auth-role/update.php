<?php

use Userstory\CompetingViewAdmin\widgets\CompetingViewWidget;
use Userstory\ModuleAdmin\components\View;
use Userstory\UserAdmin\forms\RoleForm;

/* @var View $this */
/* @var RoleForm $model */

$this->title                   = 'Обновление роли: ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => 'Роли',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url'   => [
        'view',
        'id' => $model->id,
    ],
];
$this->params['breadcrumbs'][] = 'Обновление роли';
CompetingViewWidget::widget([
    'entity' => 'authRole',
    'eid'    => $model->id,
]);
?>
<div class="auth-role-update">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
