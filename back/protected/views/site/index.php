<?php
use app\assets\AppAsset;

$bundle = AppAsset::register($this);
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="<?= $bundle->baseUrl . DIRECTORY_SEPARATOR . $bundle->js[0] ?>"></script>
</head>
<body>
    <div id="container" data-host="<?= Yii::$app->getHomeUrl() ?>"></div>
</body>
