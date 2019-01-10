<?php

return [
    'components' => require __DIR__ . '/components.config.php',
    'params'     => [
        'recovery'    => [
            'lengthCodeEmail'      => 32,
            'lengthCodeSms'        => 6,
            'confirmEmailBodyHtml' => '@vendor/userstory/user/views/emails/password-recovery.php',
            'confirmEmailBodyText' => '@vendor/userstory/user/views/emails/password-recovery.php',
            'confirmEmailURL'      => '/recovery/change',
            'subjectEmail'         => 'Восстановление пароля',
        ],
        'userProfile' => [
            'unique' => [
                'email' => false,
                'phone' => false,
            ],
        ],
    ],
];
