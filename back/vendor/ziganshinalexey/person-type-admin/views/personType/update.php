<?php

declare(strict_types = 1);

use Userstory\CompetingViewAdmin\widgets\CompetingViewWidget;
use Ziganshinalexey\PersonTypeAdmin\forms\persontype\UpdateForm;

$this->title                   = Yii::t('Admin.PersonType.PersonType', 'updatePersonType', 'Обновить "Тип личности"');
$this->params['breadcrumbs'][] = [
    'label' => 'PersonType',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;

/* @noinspection PhpUnhandledExceptionInspection */
CompetingViewWidget::widget([
    'entity' => 'personType',
    'eid'    => $model->id,
]);
?>

<div class="update">
    <?php
    /* @var UpdateForm $model */
    echo $this->renderAjax('_form', [
        'model' => $model,
    ]);
    ?>
</div>
