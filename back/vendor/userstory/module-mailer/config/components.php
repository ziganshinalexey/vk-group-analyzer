<?php

use Userstory\ModuleMailer\models\swift\Message;
use Userstory\ModuleMailer\models\swift\spool\DbSpool;
use yii\swiftmailer\Mailer as SwiftMailer;
use Userstory\ModuleMailer\entities\Mailer;
use Userstory\ComponentLog\loggers\FileTarget;

return [
    'mailer'      => [
        'class'         => SwiftMailer::class,
        'transport'     => ['class' => Swift_MailTransport::class],
        'htmlLayout'    => false,
        'textLayout'    => false,
        'messageConfig' => [
            'from'    => 'web@dev.userstory.ru',
            'charset' => 'UTF-8',
        ],
    ],
    'log'         => [
        'targets' => [
            [
                'class'        => FileTarget::class,
                'levels'       => ['info'],
                'categories'   => ['USMailer'],
                'logPath'      => '@app/runtime/mailer',
                'templatePath' => '@vendor/userstory/module-mailer/templateLog/default.php',
                'daysLife'     => 180,
            ],
        ],
    ],
    'queueMailer' => [
        'class'        => SwiftMailer::class,
        'messageClass' => Message::class,
        'transport'    => [
            'class'         => Swift_SpoolTransport::class,
            'constructArgs' => [
                'spool' => [
                    'class'         => DbSpool::class,
                    'constructArgs' => [
                        'messageLimit' => 20,
                        'modelName'    => Mailer::class,
                        'cacheKey'     => 'MailerSendCommand',
                    ],
                ],
            ],
        ],
    ],
];
