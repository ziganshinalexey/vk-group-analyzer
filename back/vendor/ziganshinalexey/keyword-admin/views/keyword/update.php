<?php

declare(strict_types = 1);

use Userstory\CompetingViewAdmin\widgets\CompetingViewWidget;
use Ziganshinalexey\KeywordAdmin\forms\keyword\UpdateForm;
use Ziganshinalexey\PersonType\dataTransferObjects\persontype\PersonType;

$this->title                   = Yii::t('Admin.Keyword.Keyword', 'updateKeyword', 'Обновить ключевую фразу');
$this->params['breadcrumbs'][] = [
    'label' => 'Keyword',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;

/* @noinspection PhpUnhandledExceptionInspection */
CompetingViewWidget::widget([
    'entity' => 'keyword',
    'eid'    => $model->id,
]);
?>

<div class="update">
    <?php
    /* @var array|PersonType $personTypeList */
    /* @var UpdateForm $model */
    echo $this->renderAjax('_form', [
        'personTypeList' => $personTypeList,
        'model'          => $model,
    ]);
    ?>
</div>
