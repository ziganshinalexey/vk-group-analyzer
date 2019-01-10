<?php

declare(strict_types = 1);

use yii\helpers\Html;
use yii\widgets\DetailView;
use Ziganshinalexey\PersonTypeAdmin\forms\persontype\ViewForm;

$this->title                   = Yii::t('Admin.PersonType.PersonType', 'view', 'Тип личности X');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('Admin.PersonType.PersonType', 'title', 'Список Тип личности'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="">
    <div class="box">
        <div class="box-header">
            <?php
            echo Html::a(Html::tag('i', '', ['class' => 'fa fa-edit']) . ' ' . Yii::t('Admin.PersonType.PersonType', 'edit', 'Редактировать'), [
                '/admin/person-type/update',
                'id' => $model->id,
            ], [
                'class' => 'btn btn-primary',
            ]);
            echo ' ';
            echo Html::a(Html::tag('i', '', ['class' => 'fa fa-trash']) . ' ' . Yii::t('Admin.PersonType.PersonType', 'delete', 'Удалить'), [
                '/admin/person-type/delete',
                'id' => $model->id,
            ], [
                'class' => 'btn btn-danger',
                'data'  => [
                    'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                    'method'  => 'post',
                ],
            ])
            ?>
        </div>
        <div class="box-body">
            <?php
            /* @noinspection PhpUnhandledExceptionInspection */
            /* @var ViewForm $model */
            echo DetailView::widget([
                'attributes' => [
                    'id',
                    'name',
                ],
                'model'      => $model,
            ]);
            ?>
        </div>
    </div>
</div>
