<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\User\entities\AuthRolePermissionActiveRecord;
use yii\helpers\Html;

/* @var View $this */
/* @var AuthRolePermissionActiveRecord $model */

$this->title                   = 'Create Auth Role Permission';
$this->params['breadcrumbs'][] = [
    'label' => 'Auth Role Permissions',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-role-permission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>

</div>
