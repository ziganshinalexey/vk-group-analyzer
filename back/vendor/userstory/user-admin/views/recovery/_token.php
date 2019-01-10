<?php

use Userstory\User\components\AuthenticationComponent;

/* @var AuthenticationComponent $authService */
$authService = Yii::$app->get('authenticationService');

if (! $authService->hasAdapter('token')) {
    return;
}

$authAdapter       = $authService->getAdapter('token');
$authenticationUri = $authAdapter->getAuthenticationUri();
$version           = $authAdapter->getLatestVersion();
$token             = $authAdapter->getOpenToken();
$signature         = $authAdapter->getSignature([
    $token,
    $authenticationUri,
    $version,
]);

?>

<form action="<?= $authAdapter->tokenServiceUri ?>" class="hidden" method="post" id="token-form">
    <input type="hidden" name="redirectUri" value="<?= htmlspecialchars($authenticationUri) ?>" />
    <input type="hidden" name="version" value="<?= htmlspecialchars($version) ?>" />
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>" />
    <input type="hidden" name="signature" value="<?= htmlspecialchars($signature) ?>" />
</form>