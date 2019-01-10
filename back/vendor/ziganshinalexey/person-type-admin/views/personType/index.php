<?php

declare(strict_types = 1);

use Userstory\ModuleAdmin\widgets\GridView\GridView;
use yii\data\ArrayDataProvider;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\FindForm;

$this->title                   = Yii::t('Admin.PersonType.PersonType', 'title', 'Типы личностей');
$this->params['contentTitle']  = $this->title;
$this->params['breadcrumbs'][] = $this->title;

/* @var ArrayDataProvider $dataProvider Содержит массив выводимых DTO */
/* @var FindForm $searchModel Форма поиска записей */

?>

<div class="language-index">
    <div class="nav-tabs-custom">
        <div class="box-body">
            <?php
            /* @noinspection PhpUnhandledExceptionInspection */
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'options'      => [
                    'class' => 'grid-view table-responsive clearfix',
                ],
                'layout'       => '{items}{summary}{pager}',
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover',
                ],
                'columns'      => ['name'],
            ]);
            ?>
        </div>
    </div>
</div>
