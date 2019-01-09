<?php

$textBeforeLink = 'The request came to change the password from your account. Follow the link to change your password:';
$textAfterLink  = ' If you did not request a password reset, you can ignore this email without any threat to the security of your account.';
$textFooter     = ' TOUCH TV - QUALITATIVE AND DIRECT COMMUNICATION OF THE VIEWER WITH YOUR CONTENT!';

/* @var string $urlHash Урл по которому необходимо сделать переход. */
?>
<table bgcolor="#343b4c" border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0;  height:100%;" width="100%">
    <tr>
        <td align="center">
            <center style="max-width: 640px; width: 100%;">
                <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0" width="640">
                    <tr>
                        <td>
                            <img src="cid:header@touch-tv" alt="" border="0" style="display:block;" width="640"/>
                            <table bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0" width="640">
                                <tr>
                                    <td style="padding: 46px 0 22px 130px;">
                                <span style="display:inline-block; width:300px; font-family: sans-serif; font-size: 24px;">
                                    <?= Yii::t('emails', 'header', 'Good afternoon!') ?>
                                </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 0 20px 107px; font-family: sans-serif; font-size: 14px; line-height: 1.57; color: #595959;">
                                <span style="display:inline-block; width:436px;">
                                    <?= Yii::t('emails', 'textBeforeLink', $textBeforeLink) ?>
                                </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <center style="max-width: 640px; width: 100%;">
                                            <table border="0" cellpadding="0" cellspacing="0" style="border: 2px dotted #315efb; margin:0; padding:0" width="400px">
                                                <tr>
                                                    <td style="padding: 18px 15px; font-family: sans-serif; font-size: 13px; color:#315efb">
                                                        <a style="color: #315efb" href="<?= $urlHash ?>"><?= $urlHash ?></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                    </td>
                                </tr>
                            </table>
                            <table border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0; color: #8d96b2; height: 46px;" width="100%" bgcolor="#ffffff">
                                <tr>
                                    <td style="padding: 10px 0 48px 107px;">
                                <span style="display:inline-block; font-size: 12px; line-height: 1.17; width:420px;">
                                    <?= Yii::t('emails', 'warning', $textAfterLink) ?>
                                </span>
                                    </td>
                                </tr>
                            </table>
                            <table bgcolor="#5d6778" border="0" cellpadding="0" cellspacing="0" style="margin:0; padding:0" width="100%">
                                <tr>
                                    <td style="padding: 23px 0 20px 79px;">
                                <span style="display:inline-block; width:500px; font-family: sans-serif; font-size: 14px; text-align: center; letter-spacing: 1px; color:#d7faff">
                                     <?= Yii::t('emails', 'footer', $textFooter) ?>
                                </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>

