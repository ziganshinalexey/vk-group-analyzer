<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\User\entities\UserProfileActiveRecord;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var View $this */
/* @var UserProfileActiveRecord $model */

$this->title                   = $model->getDisplayName();
$this->params['breadcrumbs'][] = [
    'label' => 'Пользователи',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="box">
        <div class="box-header">
<?php
echo Html::a(Html::tag('i', '', ['class' => 'fa fa-edit']) . ' Редактировать', [
    'update',
    'id' => $model->id,
], ['class' => 'btn btn-primary']) . '&nbsp;';

echo Html::a(Html::tag('i', '', ['class' => 'fa fa-trash']) . ' Удалить', [
    'delete',
    'id' => $model->id,
], [
    'class' => 'btn btn-danger',
    'data'  => [
        'confirm' => 'Are you sure you want to delete this item?',
        'method'  => 'post',
    ],
]);
?>
        </div>
        <div class="box-body">
            <?=
            DetailView::widget([
                'model'      => $model,
                'attributes' => [
                    'id',
                    'lastName',
                    'firstName',
                    'secondName',
                    'email',
                    'phone',
                    'isActive',
                    'lastActivity',
                ],
            ]) ?>

            <h3>Аутентификация</h3>

            <?php
            foreach ($model->auth as $auth) {
                echo DetailView::widget([
                    'model'      => $auth,
                    'attributes' => [
                        'authSystem',
                        'login',
                    ],
                ]);
            }
            ?>
            <h3>Персональная информация</h3>

            <?php
            echo DetailView::widget([
                'model' => $model->additionalProperties,
            ]);
            ?>
        </div>
    </div>
</div>
