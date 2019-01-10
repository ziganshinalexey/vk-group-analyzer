<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\ModuleAdmin\widgets\GridView\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\SerialColumn;
use Userstory\ModuleAdmin\widgets\GridView\ActionColumn;

/* @var View $this */
/* @var ActiveDataProvider $dataProvider */

$this->title                   = 'Роли';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-role-index">
    <p>
        <?= Html::a('Добавить роль', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <div class="box">
        <div class="box-header with-border">
                <h3 class="box-title">Список ролей</h3>
            </div>
            <div class="box-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns'      => [
                    ['class' => SerialColumn::class],
                    'id',
                    'name',
                    'description:ntext',
                    [
                        'attribute' => 'canModified',
                        'label'     => 'Системная',
                        'value'     => function($model) {
                            return 1 === $model->canModified ? 'Нет' : 'Да';
                        },
                    ],
                    'creatorId',
                    [
                        'class'          => ActionColumn::class,
                        'header'         => 'Действия',
                        'visibleButtons' => [
                            'update' => function($model) {
                                return 1 === $model->canModified;
                            },
                            'delete' => function($model) {
                                return 1 === $model->canModified;
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>