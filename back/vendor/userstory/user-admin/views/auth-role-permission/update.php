<?php

use Userstory\CompetingViewAdmin\widgets\CompetingViewWidget;
use Userstory\ModuleAdmin\components\View;
use Userstory\User\entities\AuthRolePermissionActiveRecord;
use yii\helpers\Html;

/* @var View $this*/
/* @var AuthRolePermissionActiveRecord $model */

$this->title                   = 'Update Auth Role Permission: ' . $model->roleId;
$this->params['breadcrumbs'][] = [
    'label' => 'Auth Role Permissions',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = [
    'label' => $model->roleId,
    'url'   => [
        'view',
        'roleId'     => $model->roleId,
        'permission' => $model->permission,
    ],
];
$this->params['breadcrumbs'][] = 'Update';
CompetingViewWidget::widget([
    'entity' => 'authRolePermission',
    'eid'    => $model->id,
]);
?>
<div class="auth-role-permission-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>

</div>
