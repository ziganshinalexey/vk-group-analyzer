<?php

use yii\helpers\StringHelper;
use yii\helpers\Url;

/* @var string $userName */
/* @var string $directoryAsset */

$appNameLinkRout = isset(Yii::$app->params['adminRoute']) ? Yii::$app->params['adminRoute'] : '';

?>
<header class="main-header">
    <a class="logo" href="<?= Yii::$app->homeUrl . $appNameLinkRout ?>">
        <span class="logo-mini">CM</span><span class="logo-lg"><?= Yii::$app->name ?></span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <?php
        if (count($topMenuItems)) {
            ?>
            <ul class="nav navbar-nav pull-left">
                <?php
                foreach ($topMenuItems as $item) {
                    ?>
                    <li class="dropdown">
                        <a href="<?= Url::toRoute($item['url']) ?>"
                           class="user-nav__control"
                           data-toggle="modal"
                           data-target="#<?= $item['id'] ?>-modal">
                            <i class="<?= $item['icon'] ?>"></i><span class="hidden-xs"><?= $item['label'] ?></span>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <?php
        }
        ?>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image" />
                        <span class="hidden-xs">
                            <?= StringHelper::truncate($userName, 50) ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                            <p>
                                <?= $userName ?>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= Url::to('/admin/profile') ?>" class="btn bg-light-blue btn-primary btn-flat">
                                    <?= Yii::t('Admin.Header', 'linkProfile', 'Profile'); ?>
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= Url::to('/admin/logout') ?>" data-method="post" class="btn bg-light-blue btn-primary btn-flat">
                                    <?= Yii::t('Admin.Header', 'linkLogout', 'Logout'); ?>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
            </ul>
        </div>
    </nav>
</header>