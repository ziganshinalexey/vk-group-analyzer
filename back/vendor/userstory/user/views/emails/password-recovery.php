<?php

use Userstory\User\entities\UserProfileActiveRecord;

/* @var UserProfileActiveRecord $profile */
/* @var string $urlHash */
/* @var string $hash */
/* @var string $url */
?>
<p>Добрый день, <?= $profile->getDisplayName() ?>!</p>
<p>Для смены пароля перейдите по ссылке:</p>
<p><a href="<?= $urlHash ?>"><?= $urlHash ?></a></p>
<p>Если ссылка не отображается, то введите код: <?= $hash ?> в форме по ссылке: <?= $url ?></p>
