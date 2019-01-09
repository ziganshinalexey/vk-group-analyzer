<?php

return [
    'params' => [
        'adminEmail'                    => 'a.ziganshin@userstory.ru',
        'adminRoute'                    => '',
        'recovery.confirmEmailBodyHtml' => '@app/views/emails/index.php',
        'recovery.confirmEmailBodyText' => '@app/views/emails/index.php',
        'recovery.confirmEmailURL'      => 'http://touch-tv-front.local/auth/new-password',
        'operatorId'                    => 8,
        'operatorSignature'             => 'a6e35719a1ea515cf51ae3e423d25ffa',
        'apikeyOMDb'                    => '32db71db',
        'webdav'                        => [
            'baseUri'  => 'http://upload.telebreeze.com/',
            'userName' => 'newcus',
            'password' => '1234',
        ],
    ],
];
