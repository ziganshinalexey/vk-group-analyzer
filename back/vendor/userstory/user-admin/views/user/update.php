<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\CompetingViewAdmin\widgets\CompetingViewWidget;
use Userstory\User\entities\UserProfileActiveRecord;

/* @var View $this */
/* @var UserProfileActiveRecord $model */

$this->title                   = 'Изменение пользователя: ' . $model->getDisplayName();
$this->params['breadcrumbs'][] = [
    'label' => 'Пользователи',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->getDisplayName(),
    'url'   => [
        'view',
        'id' => $model->id,
    ],
];
$this->params['breadcrumbs'][] = 'Update';
CompetingViewWidget::widget([
    'entity' => 'userProfile',
    'eid'    => $model->id,
]);
?>
<div class="user-update">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
