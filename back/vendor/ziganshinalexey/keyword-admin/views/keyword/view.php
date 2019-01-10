<?php

declare(strict_types = 1);

use yii\helpers\Html;
use yii\widgets\DetailView;
use Ziganshinalexey\KeywordAdmin\forms\keyword\ViewForm;
use Ziganshinalexey\PersonType\dataTransferObjects\persontype\PersonType;

$this->title                   = Yii::t('Admin.Keyword.Keyword', 'view', 'Ключевое фраза X');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('Admin.Keyword.Keyword', 'title', 'Список Ключевое фраза'),
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="">
    <div class="box">
        <div class="box-header">
            <?php
            echo Html::a(Html::tag('i', '', ['class' => 'fa fa-edit']) . ' ' . Yii::t('Admin.Keyword.Keyword', 'edit', 'Редактировать'), [
                '/admin/keyword/update',
                'id' => $model->id,
            ], [
                'class' => 'btn btn-primary',
            ]);
            echo ' ';
            echo Html::a(Html::tag('i', '', ['class' => 'fa fa-trash']) . ' ' . Yii::t('Admin.Keyword.Keyword', 'delete', 'Удалить'), [
                '/admin/keyword/delete',
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
            /* @var PersonType $personType */
            echo DetailView::widget([
                'attributes' => [
                    'id',
                    'text:html',
                    'personTypeId' => [
                        'attribute' => 'personTypeId',
                        'value'     => function() use ($personType) {
                           return $personType->getId();
                        },
                    ],
                ],
                'model'      => $model,
            ]);
            ?>
        </div>
    </div>
</div>
