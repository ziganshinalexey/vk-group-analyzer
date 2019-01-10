<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\UserAdmin\forms\RoleForm;
use yii\helpers\Html;
use yii\widgets\DetailView;
use rmrevin\yii\fontawesome\FA;

/* @var View $this*/
/* @var RoleForm $model */

$this->title                   = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => 'Роли',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-role-view">

    <?php
    if (1 === $model->canModified) { ?>
    <p>
        <?php echo Html::a(FA::icon('edit') . ' Редактировать',
                [
                    'update',
                    'id' => $model->id,
                ],
                [
                    'class' => 'btn btn-primary',
                ]
            ) . '&nbsp;';
        echo Html::a(FA::icon('trash') . ' Удалить',
            [
                'delete',
                'id' => $model->id,
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
    <?php } ?>

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#role-general" data-toggle="tab" aria-expanded="true">Основная информация</a></li>
            <li class=""><a href="#role-permissions" data-toggle="tab" aria-expanded="false">Полномочия</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="role-general">
            <?= DetailView::widget(
                [
                    'model'      => $model,
                    'attributes' => [
                        'id',
                        'name',
                        'description:ntext',
                        [
                            'attribute' => 'canModified',
                            'value'     => $model->canModified ? 'Нет' : 'Да',
                        ],
                        'creatorId',
                        'createDate',
                        'updaterId',
                        'updateDate',
                    ],
                ]
            ) ?>
            </div>
            <div class="tab-pane" id="role-permissions">
                <?php
                    $permissions = $model->getPermissions(true);
                    if (count($permissions) > 0) {
                        echo $this->render('_view-permissions', compact('permissions'));
                    } else {
                        echo Html::tag('h4', 'Для роли не назначены полномочия');
                    }
                ?>
            </div>
        </div>
    </div>
</div>
