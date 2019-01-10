# US Module sms - отправка сообщений на телефон

Без провайдера компонент будет только логировать отправку сообщений.

## config - конфигурация компонента

```php
'components' => [
        'sms' => [
            'class' => \Userstory\ModuleSms\components\Sms::class,
            'debug' => true, //включить debug, в этом режиме не отправляются сообщения
        ],
    ],
```

## Использование

Yii::$app->sms->send($to, $message)
$to - номер получателя.
$message - отправляемое сообщение.

## Разработка провайдера 

наследуемся от Userstory\ModuleSms\models\AbstractCurlSend

реализуем методы:
* protected function parseResponse($response); - Обработка ответа.
* protected function hasErrors(); - Наличие ошибки в ответе.
* protected function setAttributeTo($to); - Указать получателя сообщения.
* protected function getAttributeTo(); - Получить получателя сообщения.
* protected function setAttributeMessage($message); - Указать текст сообщения для отправки.
* protected function getAttributeMessage(); - Получить текст сообщения.

Необходимые атрибуты
```php
 /**
 * номер телефона получателя.
 * (Название может быть любым)
 *
 * @var string
 */
$to_attribute;

/**
* сообщение для отправки.
* (Название может быть любым)
*
* @var string
*/
$message_attribute;

/**
 * Список обязательных параметров для пересылки.
 *
 * @var array 
 */ 
$required;
```