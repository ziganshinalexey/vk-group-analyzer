<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\User\entities\AuthRolePermissionActiveRecord;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var View $this*/
/* @var AuthRolePermissionActiveRecord $model */

$this->title                   = $model->roleId;
$this->params['breadcrumbs'][] = [
    'label' => 'Auth Role Permissions',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-role-permission-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php echo Html::a('Update',
            [
                'update',
                'roleId'     => $model->roleId,
                'permission' => $model->permission,
            ],
            [
                'class' => 'btn btn-primary',
            ]
        );
        echo Html::a(
            'Delete',
            [
                'delete',
                'roleId'     => $model->roleId,
                'permission' => $model->permission,
            ],
            [
                'class' => 'btn btn-danger',
                'data'  => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method'  => 'post',
                ],
            ]
        ) ?>
    </p>

    <?= DetailView::widget(
        [
            'model'      => $model,
            'attributes' => [
                'roleId',
                'permission',
                'isGlobal',
            ],
        ]
    ) ?>

</div>
