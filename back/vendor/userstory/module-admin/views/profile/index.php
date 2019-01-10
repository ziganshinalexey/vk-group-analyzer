<?php

// @todo удалить этот файл, если не нужен!
/* @var string $directoryAsset */

$this->title                   = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
$directoryAsset                = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

?>

<div class="row">
    <div class="col-sm-4">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img
                    class="profile-user-img img-responsive img-circle"
                    src="<?= $directoryAsset ?>/img/user2-160x160.jpg"
                    alt="User profile picture">
                <h3 class="profile-username text-center"><?= $userProfile->getDisplayName() ?></h3>
                <p class="text-muted text-center"><?= $userProfile['email'] ?></p>
            </div>
        </div>
    </div>
</div>