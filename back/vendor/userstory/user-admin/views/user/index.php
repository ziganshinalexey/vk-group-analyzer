<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\ModuleAdmin\widgets\GridView\ActionColumn;
use Userstory\ModuleAdmin\widgets\GridView\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\SerialColumn;
use yii\helpers\Html;

/* @var View $this */
/* @var ActiveDataProvider $dataProvider */

$this->title                   = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">
    <p><?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-primary']) ?></p>

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Список пользователей</h3>
        </div>
        <div class="box-body">
<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        ['class' => SerialColumn::class],
        'id',
        'firstName',
        'lastName',
        'email',
        'phone',
        [
            'attribute' => 'isActive',
            'value'     => 'isActive',
            'content'   => function($model) {
                if (1 === $model['isActive']) {
                    return 'Да';
                }
                return 'Нет';
            },
        ],
        [
            'class'          => ActionColumn::class,
            'visibleButtons' => [
                'view' => false,
            ],
        ],
    ],
]);
?>
        </div>
    </div>
</div>
