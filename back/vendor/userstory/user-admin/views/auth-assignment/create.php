<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\User\entities\AuthAssignmentActiveRecord;
use yii\helpers\Html;

/* @var View $this */
/* @var AuthAssignmentActiveRecord $model */

$this->title                   = 'Create Auth Assignment';
$this->params['breadcrumbs'][] = [
    'label' => 'Auth Assignments',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>

</div>
