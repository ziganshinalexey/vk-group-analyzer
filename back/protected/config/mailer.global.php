<?php

use app\models\Message;
use yii\swiftmailer\Mailer;

return [
    'components' => [
        'mailer'      => [
            'class'        => Mailer::class,
            'messageClass' => Message::class,
            'transport'    => [
                'class' => Swift_SmtpTransport::class,
                'host'  => 'smtp',
            ],
        ],
        'queueMailer' => [
            'class'     => Mailer::class,
            'transport' => [
                'class' => Swift_SmtpTransport::class,
                'host'  => 'smtp',
            ],
        ],
    ],
];
