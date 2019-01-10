<?php

declare(strict_types = 1);

use Ziganshinalexey\PersonTypeAdmin\forms\persontype\CreateForm;

$this->context->layout         = false;
$this->title                   = Yii::t('Admin.PersonType.PersonType', 'addPersonType', 'Создать "Тип личности"');
$this->params['breadcrumbs'][] = [
    'label' => 'PersonType',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="">
    <?php
    /* @var CreateForm $model */
    echo $this->renderAjax('_form-modal', [
        'model' => $model,
    ]);
    ?>
</div>
