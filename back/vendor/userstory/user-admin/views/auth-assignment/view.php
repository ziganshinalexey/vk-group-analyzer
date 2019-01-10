<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\User\entities\AuthAssignmentActiveRecord;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var View $this */
/* @var AuthAssignmentActiveRecord $model */

$this->title                   = $model->id;
$this->params['breadcrumbs'][] = [
    'label' => 'Auth Assignments',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        echo Html::a('Update', [
            'update',
            'id' => $model->id,
        ], [
            'class' => 'btn btn-primary',
        ]);
        echo Html::a('Delete', [
            'delete',
            'id' => $model->id,
        ], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method'  => 'post',
            ],
        ])
        ?>
    </p>

    <?php
    echo DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'roleId',
            'profileId',
            'isActive',
            'creatorId',
            'createDate',
            'updaterId',
            'updateDate',
        ],
    ])
    ?>

</div>
