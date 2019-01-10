<?php

use Userstory\ModuleAdmin\assets\AdminAsset;
use Userstory\ModuleAdmin\assets\AdminLteAsset;
use Userstory\ModuleAdmin\assets\AdminLtePluginsAsset;
use Userstory\ModuleAdmin\helpers\Menu;
use Userstory\ModuleAdmin\helpers\UserHelper;
use Userstory\ModuleAdmin\widgets\Modal;
use yii\helpers\Html;
use yii\helpers\Inflector;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

if (! empty($this->blocks['content-header'])) {
    $tag   = 'h2';
    $title = $this->blocks['content-header'];
} else {
    $tag = 'h1';
    if (null !== $this->title) {
        $title = Html::decode($this->title);
    } else {
        $title = Inflector::camel2words(Inflector::id2camel($this->context->module->id));
        $title .= ( Yii::$app->id !== $this->context->module->id ) ? '<small>Module</small>' : '';
    }
}

$title = Html::tag($tag, $title);

$menuItems       = Menu::prepareItems(Yii::$app->get('menu')->getMenu('admin'));
$bottomMenuItems = Menu::prepareItems(Yii::$app->get('menu')->getMenu('admin-bottom'));
$topMenuItems    = Menu::prepareItems(Yii::$app->get('menu')->getMenu('admin-top'));

$displayName = UserHelper::getDisplayName();

AdminLteAsset::register($this);
AdminLtePluginsAsset::register($this);
AdminAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= Html::decode($this->title) ?></title>
        <?php
        echo Html::csrfMetaTags();
        $this->head();
        ?>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    </head>
    <body class="hold-transition skin-blue fixed">
    <?php $this->beginBody() ?>
    <div class="wrapper">
            <?php
            echo $this->render('_header.php', [
                'directoryAsset' => $directoryAsset,
                'userName'       => $displayName,
                'topMenuItems'   => $topMenuItems,
            ]);

            echo $this->render('_left.php', [
                'directoryAsset'  => $directoryAsset,
                'userName'        => $displayName,
                'menuItems'       => $menuItems,
                'bottomMenuItems' => $bottomMenuItems,
            ]);

            echo $this->render('_content.php', [
                'directoryAsset' => $directoryAsset,
                'content'        => $content,
                'title'          => $title,
                'breadcrumbs'    => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]);
            ?>
        </div>
    <?php
    foreach ($topMenuItems as $item) {
        Modal::begin([
            'id'            => $item['id'] . '-modal',
            'closeButton'   => false,
            'clientOptions' => false,
            'type'          => $item['type'],
        ]); ?>
        <div class="text-center">
            <i class="fa fa-refresh fa-spin fa-1x fa-fw"></i>
            <span><?= Yii::t('GameServer.Trainer', 'loading', 'Loading...') ?></span>
        </div>
        <?php Modal::end();
    }

    $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
