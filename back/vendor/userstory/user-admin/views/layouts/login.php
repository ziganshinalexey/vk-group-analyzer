<?php

use yii\helpers\Html;
use Userstory\UserAdmin\assets\LoginAsset;

/* @var string $content */

LoginAsset::register($this);
$this->beginPage();

?><!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
        <?php $this->head() ?>
    </head>

    <body class="hold-transition login-page">
        <?php
        $this->beginBody();
        echo $content;
        $this->endBody();
        ?>
    </body>
</html>
<?php $this->endPage() ?>