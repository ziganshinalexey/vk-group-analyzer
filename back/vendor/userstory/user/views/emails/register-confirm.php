<?php

use Userstory\User\entities\UserProfileActiveRecord;

/* @var UserProfileActiveRecord $profile */
/* @var string $url */
?>
<p>Добрый день, <?= $profile->getDisplayName() ?>!</p>
<p>Для подтверждения регистрации на сайте перейдите по ссылке:</p>
<p><a href="<?= $url ?>"><?= $url ?></a></p>