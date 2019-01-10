<?php

use Userstory\User\entities\UserProfileActiveRecord;
use yii\helpers\Url;

/* @var UserProfileActiveRecord $profile */
?>
<p>Добрый день, <?= $profile->getDisplayName() ?>!</p>
<p>Ваш аккаунт на корпоративном портале KDV активирован.</p>
<p>Чтобы воспользоваться сервисами портала, перейдите по ссылке
    <a href="<?= Url::home(true) ?>"><?= Url::home(true) ?></a>.</p>
<p>С уважением, администрация корпоративного портала.</p>