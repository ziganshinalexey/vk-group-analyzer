## Модуль админки

Предназначен для унификации административной части. По умолчанию, перенаправляет на себя все маршруты вида:
```
http://site.org/admin
http://site.org/admin/<controller>
http://site.org/admin/<controller>/<action>
```

### Разделы
К модулю админки нужно подключать внешние контроллеры через controllerMap в конфиге модуля или основном конфиге:
```php
return [
    'modules'    => [
        'admin'   => [
            'controllerMap' => [
                'user' => [
                    'class'   => \Userstory\ModuleUserProfile\controllers\UserController::class,
                    'layout'  => '@vendor/userstory/module-admin/views/layouts/main',
                    'viewMap' => [
                        'index'  => '@vendor/userstory/module-user-profile/views/user/index',
                        'view'   => '@vendor/userstory/module-user-profile/views/user/view',
                        'update' => '@vendor/userstory/module-user-profile/views/user/update',
                        'create' => '@vendor/userstory/module-user-profile/views/user/create',
                    ],
                ],
            ],
        ],
    ],
],
```

### Меню
Меню может быть одноуровневым или двухуровневым.
Для добавления пункта меню, его следует определить в конфиге модуля или основном конфиге:
```php
return [
    'components' => [
        'menu'       => [
            'items' => [
                'admin' => [
                    'user' => [
                        'title' => 'Пользователи',
                        'icon'  => 'fa fa-user',
                        'route' => '/admin/user',
                        'child'      => [
                            'country' => [
                                'title'      => 'Countries',
                                'icon'       => 'fa fa-binoculars',
                                'route'      => '/admin/country',
                                'permission' => 'Admin.SaaS.Country.Index',
                            ],
                            'city'    => [
                                'title'      => 'Cities',
                                'icon'       => 'fa fa-home',
                                'route'      => '/admin/city',
                                'permission' => 'Admin.SaaS.City.Index',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
],
```



### Виджеты

#### GridView

Виджет используется для отображения данных в таблице.

Опции:
* `attribute` - Ключ, связанный с моделью
* `filterInputOptions`
    * `placeholder` - placeholder для инпута
    * `icon` = название иконки [Font Awesome]
* `popover` - Html контент для показа во всплывающем бабле
* `statusLabel` - Параметры для лейбла со статусом внутри ячейки

Пример конфигурации:
```php
use <path to ModuleAdmin>\widgets\GridView\ActionColumn;
use <path to ModuleAdmin>\widgets\GridView\GridView;

echo GridView::widget ([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'columns'      => [
        [
            'attribute' => 'name',
            'filterInputOptions' => [
                'placeholder' => 'Поиск по имени',
                'icon'        => 'search',
            ],
            'statusLabel' => [
                'text'       => 'some text',
                'type'       => 'success',
                'alignRight' => true
            ],
            'popover'   => function($model, $key, $index) {
                return 'some html';
            },
        ],
        [
            'class'    => ActionColumn::class,
            'header'   => Yii::t ('Admin.User', 'actions', 'Действия'),
            'template' => '{view} {update} {delete}',
        ],
    ],
]);
```

#### StatusLabel

Виджета для отображения лейбла со статусом

Опции:
* `text` - Текст внутри лейбла
* `type` - Тип лейбла: `'error' | 'danger' | 'success' | 'info' | 'warning'`
* `option` - HTML-атрибуты для лейбла

Пример конфигурации:
```php
use <path to ModuleAdmin>\widgets\StatusLabel;

echo StatusLabel::widget ([
    'text'   => 'some text',
    'type'   => 'success',
    'option' => [],
])
```

#### Datepicker

Виджет для отображения датапикера

* `model` - Модель
* `attribute` - Название атрибута
* `range` - Флаг, указывает на возможность ввода двух дат в одно поле
* `options` - HTML-атрибуты для датапикера
* `pickerOptions` - HTML-атрибуты для обертки инпута

```php
use <path to ModuleAdmin>\widgets\DatePicker;

echo DatePicker::widget([
    'model' => $model,
    'attribute' => 'period',
    'range' => true,
]);
```

### Modal
Виджет для отображения модального окна.

* `id` - Уникальный идентификатор
* `size` - Размер модального окна: `SIZE_LARGE`, `SIZE_SMALL`, `SIZE_DEFAULT`
* `closeButton` - Нужно ли отображать кнопку "закрыть"
* `clientOptions` - Требует false для подгрузки контента через ajax
* `forceUpdate` - принудительно обновлять контент для модальных окон
* `type` - Внешний вид модального окна: `default | primary | info | warning | success | danger`

```php
echo Html::button ('open modal', [
    'data-toggle' => 'modal',
    'data-target' => '#modal',
]);

Modal::begin ([
    'id'            => 'modal',
    'size'          => Modal::SIZE_LARGE,
    'closeButton'   => false,
    'type'          => 'info',
]);
// контент здесь
Modal::end ();
```

url через ajax
```php
echo Html::a ('open ajax modal', $url, [
    'data-toggle' => 'modal',
    'data-target' => '#modal',
]);

Modal::begin ([
    'id'            => 'modal',
    'size'          => Modal::SIZE_LARGE,
    'closeButton'   => false,
    'clientOptions' => false,
    'forceUpdate'   => true,
    'type'          => 'info',
]);
Modal::end ();
```

#### Alert

Виджет для отображения алертов и сообщений.

Задать сообщение:
```php
Yii::$app->getSession()->setFlash('error', '<b>Alert!</b> Danger alert preview. This alert is dismissable.');
```

Вывести виджет в шаблоне:
```php
echo Alert::widget();
```

### TODO:
 - [ ] дополнить раздел меню описанием ключей.
 - [ ] в виджетах вынести html во вьюхи
 - [ ] описать в ридми виджеты Alert и Menu


[Font Awesome]: <http://fontawesome.io/icons/>
