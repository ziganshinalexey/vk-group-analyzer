<?php

declare(strict_types = 1);

use Userstory\ModuleAdmin\widgets\GridView\ActionColumn;
use Userstory\ModuleAdmin\widgets\GridView\GridView;
use Userstory\ModuleAdmin\widgets\Modal;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\FindForm;

$this->title                   = Yii::t('Admin.PersonType.PersonType', 'title', 'Список Тип личности');
$this->params['contentTitle']  = $this->title;
$this->params['breadcrumbs'][] = $this->title;

/* @var ArrayDataProvider $dataProvider Содержит массив выводимых DTO */
/* @var FindForm $searchModel Форма поиска записей */

?>

<div class="language-index">
    <div class="nav-tabs-custom">
        <div class="timeline-header clearfix">
            <?php
            if (Yii::$app->user->can('Admin.PersonType.PersonType.Create')) {
                echo Html::a(Yii::t('Admin.PersonType.PersonType', 'create', 'Добавить'), ['create'], [
                    'class'       => 'btn btn-lg btn-info btn-flat pull-right',
                    'data-toggle' => 'modal',
                    'data-target' => '#modal',
                ]);
            }
            ?>
        </div>
        <div class="box-body">
            <?php
            /* @noinspection PhpUnhandledExceptionInspection */
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'options'      => [
                    'class' => 'grid-view table-responsive clearfix',
                ],
                'layout'       => '{items}{summary}{pager}',
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover',
                ],
                'columns'      => [
                    [
                        'class'          => ActionColumn::class,
                        'header'         => Yii::t('Admin.PersonType.PersonType', 'actionsHeader', 'Действия'),
                        'contentOptions' => [
                            'style' => 'width:1px',
                        ],
                        'template'       => '{update} {delete}',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'id'            => 'modal',
    'size'          => Modal::SIZE_LARGE,
    'closeButton'   => false,
    'clientOptions' => false,
    'forceUpdate'   => true,
    'type'          => 'default',
]);
Modal::end();
?>
