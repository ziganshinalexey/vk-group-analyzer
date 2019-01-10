<?php

declare(strict_types = 1);

use Ziganshinalexey\KeywordAdmin\forms\keyword\CreateForm;
use Ziganshinalexey\PersonType\dataTransferObjects\persontype\PersonType;

$this->context->layout         = false;
$this->title                   = Yii::t('Admin.Keyword.Keyword', 'addKeyword', 'Создать ключевую фразу');
$this->params['breadcrumbs'][] = [
    'label' => 'Keyword',
    'url'   => ['index'],
];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="">
    <?php
    /* @var array|PersonType $personTypeList */
    /* @var CreateForm $model */
    echo $this->renderAjax('_form-modal', [
        'personTypeList' => $personTypeList,
        'model'          => $model,
    ]);
    ?>
</div>
