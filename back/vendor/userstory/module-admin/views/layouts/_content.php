<?php

use Userstory\ModuleAdmin\widgets\Alert;
use yii\widgets\Breadcrumbs;

$params = [
    'year'               => date('Y'),
    'defaultTranslation' => '{year}. All rights reserved',
];
?>

<div class="content-wrapper">
    <?php if (! empty($this->params['breadcrumbs'])) { ?>
        <section class="content-header">
            <div class="row">
                <div class="content-header__title col-lg-7 clearfix">
                    <?php
                    /* @var string $contentTitle */
                    echo $title;
                    ?>
                </div>
                <div class="content-header__breadcrumbs col-lg-5">
                    <?php
                    echo Breadcrumbs::widget([
                        'tag'      => 'ol',
                        'links'    => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'homeLink' => [
                            'label'    => Yii::t('Admin.Breadcrumbs', 'Home', 'Home'),
                            'url'      => '/',
                            'template' => '<li><a><i class="fa fa-dashboard"></i></a>{link}</li>  ',
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </section>
    <?php } ?>

    <section class="content  j-content">
        <?php
        /* @var string $content */
        echo Alert::widget([
            'duration' => ['success' => 10],
        ]);
        echo $content;
        ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <?= Yii::t('Admin.Footer', 'madeIn', 'Made In') ?> <a href="https://userstory.ru/">USERSTORY</a>
    </div>
    <strong>©<?= Yii::$app->name . ' ' . Yii::t('Admin.Footer', 'Allrightsreserved', $params); ?></strong>
</footer>
