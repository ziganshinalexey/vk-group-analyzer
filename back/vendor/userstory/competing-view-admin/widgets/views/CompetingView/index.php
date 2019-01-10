<?php

use Userstory\ModuleAdmin\components\View;
use Userstory\CompetingViewAdmin\assets\CompetingViewAsset;

/* Представление для работы виджета модуля "Конкурентный просмотр". */
 /* @var string  $entity  Имя сущности. */
 /* @var integer $eid     Идентификатор сущности. */
 /* @var array   $options Дополнительные параметры. */

CompetingViewAsset::register(Yii::$app->view);


Yii::$app->view->registerJs("
    compentingViewModule.setParams({
        viewUrl: '/v1/competingView/',
    });", View::POS_LOAD, 'compenting_view_set');

Yii::$app->view->registerJs("compentingViewModule.addView({
        entity: '" . $entity . "',
        id: '" . $eid . "'
    });", View::POS_LOAD, 'compenting_view_' . $entity);
