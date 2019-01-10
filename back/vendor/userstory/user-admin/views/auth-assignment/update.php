<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\CompetingViewAdmin\widgets\CompetingViewWidget;
use Userstory\User\entities\AuthAssignmentActiveRecord;
use yii\helpers\Html;

/* @var View $this */
/* @var AuthAssignmentActiveRecord $model */

$this->title                   = 'Update Auth Assignment: ' . $model->id;
$this->params['breadcrumbs'][] = [
    'label' => 'Auth Assignments',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->id,
    'url'   => [
        'view',
        'id' => $model->id,
    ],
];
$this->params['breadcrumbs'][] = 'Update';
CompetingViewWidget::widget([
    'entity' => 'authAssignment',
    'eid'    => $model->id,
]);
?>
<div class="auth-assignment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    echo $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
