<?php

use yii\helpers\VarDumper;

/* Представление для отображения лога api запросов.*/
/* @var DateTime $date */
/* @var string $level */
/* @var string $category */
/* @var string $text */

echo $date->format(DATE_ISO8601) ?> from <?= Yii::$app->request->userIP ?>:
<?= VarDumper::dumpAsString($text) ?>


**************************************************************************************************************
