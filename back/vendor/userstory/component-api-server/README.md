# API-сервер


## Предпосылки создания

Для систематизации обмена данными между веб-сервером и клиентом был разработан API REST стандарт. В рамках этого стандарта был разработан данный API-сервер.


## Какие цели решает

Целью API-сервера является обработка поступающих запросов API REST стандарта. 


## Подключение и конфигурация

Для данного компонента необходимо настроить конфигурации. Если подключен автосборщик конфигураций, то это будет сделано автоматически. Иначе вам необходимо его подключить. Соответствующую информацию вы можете посмотреть в документации по автосборщику конфигураций.


## Жизненный цикл

API-сервер имеет следующий жизненный цикл:
 
1. Текущий запрос проверяется на шаблон "/api" и в случае, если совпадает - управление запросом переходит к API-серверу.
2. Строка запроса парсится в соответствии с правилами компонента `Userstory\ComponentApiServer\components\ApiServerComponent::$rules` и возвращается название действия контроллера обработчика, 
заданное в соответствующем совпавшем правиле, а также параметры из строки запроса, которые будут переданы как параметры контроллера.
3. Контроллер обработчик на основе переданных параметров может либо сам обработать запрос и вернуть результат `Userstory\ComponentApiServer\models\rest\Response`, либо передать обработку соответствующему пользовательскому действию.
4. Пользовательское действие на основе переданных параметров из контроллера обработчика производит необходимые операции и возвращает результат.
5. API-сервер получает ответ `Userstory\ComponentApiServer\models\rest\Response` от контроллера обработчика, заполняет `yii\web\Application::$response`, отправляет ответ и завершает приложение.        


## Конфигурация


### Класс REST API ответа [ `Userstory\ComponentApiServer\components\ApiServerComponent::$response` ] 

- Доступен в пользовательском действии `$this->response`, а также глобально `Yii::$app->apiServer->response`.
- Используется для заполнения api ответа для его последующей отправки.
- Включает в себя основные методы для работы:
 
    `Userstory\ComponentApiServer\models\rest\Response::addError()` - добавление данных ошибки в ответ
    
    `Userstory\ComponentApiServer\models\rest\Response::addNotify()` - добавление данных уведомления в ответ
    
    `Userstory\ComponentApiServer\models\rest\Response::addData()` - добавление основных данных в ответ по ключу (при формировании сложных ответов в несколько этапов)
    
    `Userstory\ComponentApiServer\models\rest\Response::setData()` - добавление основных данных в ответ без ключа (возможно обновление уже присутстсвующих данных при совпадении ключей)
    
    `Userstory\ComponentApiServer\models\rest\Response::createPage()` - создание объкта пагинатора на основе переданных данных и возврат созданного объекта
    
    `Userstory\ComponentApiServer\models\rest\Response::setPage()` - установка своего объкта пагинатора
    

### API правила [ `Userstory\ComponentApiServer\components\ApiServerComponent::$rules` ]
 
Каждое правило состоит из: 


#### Метод(ы) доступа:

- `GET`, `PUT`, `CREATE`, `DELETE`, `POST`. 
- Может быть задан более одного. Например `[GET]`, `[CREATE,POST]` и т.д.
 

#### Паттерн поиска:

**ВАЖНО: Паттерн не должен содержать контроллер `system` (`system/...`) - он зарезервирован как системный и не может быть использован в пользовательских правилах!
 
- Может содержать элементы (`<version>`, `<language>` и т.д. - любое слово на латинице заключенное в угловые скобки и присутствующее в элементах правил (см. `Userstory\ComponentApiServer\components\ApiServerComponent::$ruleItems`))

- Может содержать символы `()?` для формирования необязательной группы внутри правила. 
   

#### Действие контроллера, обрабатывающее запрос: 

Контроллер **должен быть** наследован от `Userstory\ComponentApiServer\controllers\BaseApiController`. 

Действие **должно иметь** префикс `rest-`, сам **метод действия должен быть** c префиксом `restAction`. Например: `rest-index` соответствует методу `restActionIndex()` контроллера.    
 

## Использование

### Создание пользовательского действия

### ***Ознакомьтесь со стандартом REST API, который используют в компании.***

### Отличие пользовательский действий (REST действий) от обычных действий контроллера.

- В метод `run()` автоматически передаются основные параметры запроса из паттерна поиска (`$routeParams`) и дополнительные параметры из строки запроса (`$queryParams`)  
- Пользователское действие наследует класс `Userstory\ComponentApiServer\actions\ApiAction`.
- Пользовательскому действию доступен объект REST API ответа (см. описание выше)
- Пользовательское действие должно реализовывать дополнительный метод `info()`, возвращающий краткую информацию об этом действии.

***Пример пользовательского действия:***  

```php
class CreateUserAction extends Userstory\ComponentApiServer\actions\ApiAction
{
  public function run(array $routeParams = [], array $queryParams = [])
  {
      $user = new User();
              
      if ($user->load(Yii::$app->request->post()) && $user->save()) {
          
          $this->response->addNotify(1, 'Пользователь успешно создан!');  
      
          // здеь можно вернуть просто массив, можно строку, можно ничего не возвращать.
          // результат будет записан в объект API ответа (он же $this->response). 
          return ArrayHelper::toArray($user, [
              User::class => [
                  'id',
                  'firstName',
                  'lastName',
              ],
          ]);
      }
     
      // если надо устанавливаем код ошибки
      Yii::$app->response->statusCode = 400;
      
      // добавляем данные ошибки в api ответ
      $this->response->addError(2, 'Ошибка при создании пользователя', '', $user->errors);
  }

  public static function info()
  {
      return [
          'message' => 'Создание нового пользователя',
      ];  
  }
}
```

### Установка формата ответа по умолчанию.

Добавьте пользовательскую конфигурацию, описывающую используемый формат ответа.

На данный момент поддерживаются два формата:

- \yii\web\Response::FORMAT_JSON
- \yii\web\Response::FORMAT_XML

Json формат используется по умолчанию и не требует явного задания в конфиге.

Пример:

```php
return [
    ...
    'components' => [
        'apiServer'    => [
            ...
            'responseFormat' => \yii\web\Response::FORMAT_XML,
            ...
        ],
        ...
    ],
    ...
]; 
```

### Установка формата ответа конкретного экшена.

Для установки формата ответа экшена необходимо выполнить следующее:

```php

class TestAction extends ApiAction
{
    ...
    
    public function run(array $routeParams = [], array $queryParams = [])
    {
        ...
        $this->response->setFormat(yii\web\Response::FORMAT_XML);
        ...
    }
    ...
}
 
```

Формат ответа, выставленный в экшене, считается более приоритетным, чем формат,
используемый по умолчанию и распространяется только на ответ экшена,
в котором был установлен. 

На данный момент поддерживаются два формата:

- \yii\web\Response::FORMAT_JSON
- \yii\web\Response::FORMAT_XML


### Создание пользовательской конфигурации

Добавьте пользовательскую конфигурацию описывающую возможные пользовательские действия:

```php
return [
    'class'   => \Userstory\ComponentApiServer\components\ApiServerComponent::class,
    'actions' => [
        'v1'     => [
            'user/index'         => app\api\v1\ListUserAction::class,             // вывести список пользователей (соответствует запросу GET /api/v1/users/index)
            'user/create'        => app\api\v1\CreateUserAction::class,           // создать нового пользователя (соответствует запросу CREATE /api/v1/users)
            'user/view'          => app\api\v1\ViewUserAction::class,             // вывести информацию о пользователе (соответствует запросу GET /api/v1/users/10, "10" будет передан как параметр в действие)
            'user/update'        => app\api\v1\UpdateUserAction::class,           // обновить данные пользователя (соответствует запросу PUT /api/v1/users/10, "10" будет передан как параметр в действие)
            'user/delete'        => app\api\v1\DeleteUserAction::class,           // удалить пользователя (соответствует запросу DELETE /api/v1/users/10, "10" будет передан как параметр в действие)
            'user/view/comment'  => app\api\v1\ListCommentsUserAction::class,     // вывести список комментариев пользователя (соответствует запросу GET /api/v1/users/10/comments, "10" и "15" будут переданы как параметры в действие)
            ...
        ],
        'v2.0.6' => [
            'user/comment/view/countered' => app\api\v2.0.6\TestAction::class,    // вывести комментарий пользователя по экшену (countered) (соответствует запросу GET /api/v1/users/10/comments/countered, "10" будет передан как параметр в действие)
            ...
        ],
    ],
]; 
```

### Вызов пользовательского действия

Вызов пользовательского действия из контроллера обработчика сводится к вызову метода `Userstory\ComponentApiServer\controllers\BaseApiController::runUserAction()`

***Пример:***

```php
public function restActionView(array $routeParams = [], array $queryParams = [])
{
    // запрос можно обработать здесь и вернуть результат, используя Yii::$app->apiServer->response как объект API ответа для наполнения данными.
    // .......ваш код здесь ............
    
    // или вызвать пользовательское действие и вернуть результат его работы
    return $this->runUserAction('view', $routeParams, $queryParams);
}
```

### Работа с исключениями и HTTP кодами ответа

Вы можете в пользовательских действиях и в контроллерах-обработчиках использовать как обычно любые HTTP исключения + установку статус кода `yii\web\Response::statusCode`.
  
## Вспомогательные роуты
  
Помимо описанных роутов согласно спецификации API добавлены следущие вспомогательные роуты:
  
`api/system/info` - выводит информацию о всех добавленных пользовательских действиях  
`api/<version>/system/info` - выводит информацию о всех добавленных пользовательских действиях конкретной версии (`<version>`)
`api/system/version` - выводит информацию о текущей версии протокола взаимодействия 
  
## Логирование запросов

Логирование происходит автоматически при каждом запросе.
Если необходимо отформатировать данные поступающие в лог,- используйте колбэк `\Userstory\ComponentApiServer\logger\LogBehavior::$formatter`:

***Например:***
 
```php
return [
    'class'   => \Userstory\ComponentApiServer\components\ApiServerComponent::class,
    ...
    'as log'  => [
        'class'     => \Userstory\ComponentApiServer\logger\LogBehavior::class,
        'formatter' => function($logData) {
            
            // здесь ваши операции с массивом $logData = ['url' => ..., 'x-method' => ..., 'request' => ..., 'response' => ...]
            
            return $logData;
        },
    ],
]; 
```

## Кроссдоменные запросы

Cross-origin resource sharing (CORS; с англ. — «совместное использование ресурсов между разными источниками») — технология современных браузеров, 
которая позволяет предоставить веб-странице доступ к ресурсам другого домена.

component-api-server поддерживает данную технологию.

Для того, чтобы запросы, которые обрабатывает component-api-server, могли быть отправлены с других доменов,
необходимо к ответу сервера добавить следующие заголовки:

```
  Access-Control-Allow-Origin: *                                        # Список доментов, с которых разрешены запросы. * - любой домен.
  Access-Control-Allow-Method: POST,GET,OPTIONS,PUT,DELETE,CREATE       # Список HTTP методов, которые можно использовать в крос-доменных запросах.
  Access-Control-Allow-Headers: x-http-method-override, content-type    # Список заголовков, которые разрешено использовать в кросдоменных запросах.
  Access-Control-Allow-Credentials: true                                # Разрешает передавать в кросдосенный запрос куки и заголовки авторизации. 
```
 
Передаваемые в ответ заголовки настаиваются в конфиге следующим образом:

```php
return [
    'class'   => \Userstory\ComponentApiServer\components\ApiServerComponent::class,
    
    ...
    
    'defaultHeaders' => [
        'Access-Control-Allow-Origin'       => '*',
        'Access-Control-Allow-Method'       => 'POST,GET,OPTIONS,PUT,DELETE,CREATE',
        'Access-Control-Allow-Headers'      => 'x-http-method-override, content-type',
        'Access-Control-Allow-Credentials'  => 'true',
    ],
    
    ...
    
]; 

```
В абстрактном классе AbstractApiAction.php метод getOptions() формирует заголовки и отправляет браузеру. Данный метод можно переопределить у потомков
и использовать свои заголовки для каждого действия.

## Гидратор (С верисии 0.2.28)
 
У базового класса апи действия появилось свойство гидратора.
Сеттер которого принимает класс гидратор и преобразовывает его в объект.
Обращение к свойству внутри апи действия необходимо через метод геттера.

## Нестандартные апи (С верисии 0.2.34)
 
Появилась возможность использовать нестандартные урл для апи.
Для таких апи у компонента появилось свойство, которое конфигурируется через конфигурацию проекта:
```
    /**
     * Список апи действий с особым url.
     *
     * @var array
     */
    protected $specialActionList = [];
```
Сам конфиг будет выглядить следующим образом:
```
    'apiServer'    => [
        'actions'           => [
            'v1' => [
                . . .
            ],
        ],
        'specialActionList' => [
            'profile/post/auth'            => ConsoleAuthUserAction::class,
            'profile/put/auth'            => ConsoleAuthUserAction::class,
            'profile/get/auth'            => ConsoleAuthUserAction::class,
            'profile/create/auth'            => ConsoleAuthUserAction::class,
        ],
    ],
```
Метод можно передовать через заголовок (x-http-method-override) или вне заголовка.

curl -H 'x-http-method-override:POST' http://web/profile/auth.

## Будет реализовано
 
* Фильтрация данных
* Авторизация
* Множественное создание ресурсов
* Загрузка файлов
* Асинхронные задачи