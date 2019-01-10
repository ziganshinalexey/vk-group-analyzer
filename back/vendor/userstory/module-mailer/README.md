Организация очереди рассылки.
=================================

В дебаг режиме отправляет сразу на почту, отключить можно в конфиге.

Требуемые компоненты:
---------------------

* Рассылка идет через [swiftmailer](http://www.yiiframework.com/doc-2.0/ext-swiftmailer-index.html "swiftmailer")
* Что бы очередь писем хранить в БД требуется userstory/component-migration
* Требуется userstory/component-autoconfig

Возможности
-----------

* Организация очереди в памяти (нативное)
* Организация очереди через файловое хранилище (доработано)
* Организация очереди через базу данных (доработано)

### Организация очереди в памяти

Очередь живет пока работает скрипт.

пример конфигурации:

```php
return [
    'components' => [
        'queueMailer' => [
            'class'     => yii\swiftmailer\Mailer::class,
            'transport' => [
                'class' => 'Swift_SpoolTransport',
                'constructArgs' => [
                    'spool' => [
                        'class' => Swift_MemorySpool::class,
                    ],
                ],
            ],
        ],
    ],
],
```

### Организация очереди через файловое хранилище

пример конфигурации:

```php
return [
    'components' => [
        'queueMailer' => [
            'transport' => [
                'class' => 'Swift_SpoolTransport',
                'constructArgs' => [
                    'spool' => [
                        'class' => Userstory\ModuleMailer\models\swift\spool\FileSpool::class,
                        'constructArgs' => [
                            'path' => 'путь/до/хранилища',
                            'messageLimit' => 20, // количество сообщений отправляемых за 1 раз
                            'classCache'   => yii\caching\FileCache::class, // класс для кеширования
                            'cacheKey'     => 'MailerSendCommand', // ключь хранения значения состояния рассылки
                        ]
                    ],
                ],
            ],
        ],
    ],
],
```

### Организация очереди через базу данных

пример конфигурации:

```php
return [
    'components' => [
        'queueMailer' => [
            'class'     => 'yii\swiftmailer\Mailer',
            'messageClass' => Userstory\ModuleMailer\models\swift\Message::class,
            'transport' => [
                'class'         => Swift_SpoolTransport::class,
                'constructArgs' => [
                    'spool' => [
                        'class'         => Userstory\ModuleMailer\models\swift\spool\DbSpool::class,
                        'constructArgs' => [
                            'messageLimit' => 20, // количество сообщений отправляемых за 1 раз
                            'Userstory\ModuleMailer\entities\Mailer', // модель хранения данных
                            'classCache'   => yii\caching\FileCache::class, // класс для кеширования
                            'cacheKey'     => 'MailerSendCommand', // ключь хранения значения состояния рассылки
                        ],
                    ],
                ],
            ],
        ],
    ],
],
```


### Организация очереди

Отправлять письма следует через queueMailer. Процесс формирования и отправки письма аналогичен работа через swiftmailer - доступны все методы.

```php
Yii::$app->queueMailer->compose ()
         ->setFrom (['from@mail.com' => 'Company'])
         ->setTo (['email@mail.com' => 'I. Ivanov'])
         ->setSubject ('Subject')
         ->setHtmlBody ('text html <b>bold</b>')
         ->attach ($pathFile1)
         ->send ();
```

### Отчет и логирование

Отчеты складываются в лог который ведет userstory/component-log (расширение стандартного логирования Yii), на уровень info в категорию USMailer.

Необходимо настроить конфиг файл для логов, пример:

```php
return [
    'components' => [
        'log'         => [
            'targets' => [
                [
                    'class'        => \Userstory\ComponentLog\loggers\FileTarget::class,
                    'levels'       => ['info'],
                    'categories'   => ['USMailer'],
                    'logPath'      => '@app/runtime/mailer',
                    'templatePath' => '@vendor/userstory/module-mailer/templateLog/default.php',
                    'daysLife'     => 180,
                ],
            ],
        ],
    ],
],
```

консольная команда для удаления старых логов: mailer/log/remove --path=@app/runtime/mailer --days=5
--path - путь до папки где хранятся логи.
--days - время жизни файла в днях.

### Отправки из очереди

Чтоб отправить письмо из очерди требуется сменить вид транспорта, например на smtp,
формируем компоненту или используем уже объявленную от swiftmailer.

smtp для swiftmailer прописывается так (пример для gmail):

```php
return [
    'components' => [
        'mailer'      => [
            'class'     => yii\swiftmailer\Mailer::class,
            'transport' => [
                'class'    => Swift_SmtpTransport::class,
                'host'     => 'ssl://smtp.gmail.com',
                'username' => 'user@mail.test',
                'password' => 'password',
                'port'     => '465',
                'plugins'  => [
                    [
                        'class'         => Swift_Plugins_LoggerPlugin::class,
                        'constructArgs' => [new Swift_Plugins_Loggers_ArrayLogger],
                    ],
                ],
            ],
        ],
    ],
],
```


далее в коде получаем транспорт
```php
$transport = Yii::$app->mailer->getTransport ();
```

и подсовывем его в нашу рассылку
```
Yii::$app->queueMailer->getTransport ()->getSpool ()->flushQueue ($transport);
```


Консольная команда, для отправки по крону php yii mailer/send
