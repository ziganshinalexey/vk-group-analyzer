<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\ModuleAdmin\widgets\GridView\GridView;
use Userstory\User\entities\AuthAssignmentActiveRecord;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

/* @var View $this */
/* @var ActiveDataProvider $dataProvider */

$this->title                   = 'Auth Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Auth Assignment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'role',
                'value'     => function(AuthAssignmentActiveRecord $a) {
                    return (string)$a->roleId . ' : ' . $a->role->name;
                },
            ],
            [
                'attribute' => 'profile',
                'value'     => function(AuthAssignmentActiveRecord $a) {
                    return (string)$a->profileId . ' : ' . $a->profile->firstName . ' ' . $a->profile->lastName;
                },
            ],
            'isActive',
            'creatorId',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
