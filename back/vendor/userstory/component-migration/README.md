## Компонент миграций

### Предпосылки создания

При добавлении новых пакетов в приложение часто требуется применить миграции, идущие вместе с пакетом. 

Когда пакетов много, применение миграций может отнимать достаточное время. Для упрощения создания и применения миграций был разработан этот компонент.
  
### Какие цели решает этот компонент

Целью компонента миграций является ускорение работы с миграциями, а также расширение стандартных возможностей работы с миграциями в Yii2. 

### Подключение

Если подключен автосборщик конфигураций, то это будет сделано автоматически. Иначе вам необходимо его подключить. 
Соответствующую информацию вы можете посмотреть в документации по автосборщику конфигураций.

### Использование консоли

Работа с консольной командой ``php yiic migrate`` аналогична консольной команде yii2 с некоторым отличием:
   
   - отключена интерактивность при применении миграций (нет необходимости подтверждать применение каждой миграции) 
   - добавлены новые команды
   - новые миграции можно не прописывать в параметре ``migrationPath``
   
Для начала использования вам необходимо задать ``controllerMap`` в консольном файле конфигурации вашего модуля/компонента (``config/console.config.php``) как показано в примере ниже.

#### Пример конфигурации в файле console.config.php:

    ```php
    return [
        'controllerMap' => [
            'migrate' => [
                'migrationPathList' => ['@vendor/userstory/module-competing-view/migrations'],
            ],
        ],
    ];
    ```
    
Применение всех миграций сводится к простой команде ``php yiic migrate``

#### Новые команды

При работе с миграциями можно использовать новую команду ``php yiic migrate/flush``, которая сбрасывает кэш базы данных.

### Использование при разработке миграций

При создании новой миграции командой ``php yiic migrate/create <migration-name>``, класс новой миграции теперь наследуется от ``\Userstory\ComponentMigration\models\db\Migration``.

Это позволяет использовать дополнительные возможности при разработке миграций.

#### Новые возможности при работе с миграциями:

 1. Добавлено свойство ``[[Userstory\ComponentMigration\models\db\Migration::tableName|tableName]]``, определяющее имя связанной с данной миграцией таблицей.

 2. Добавлено свойство ``[[Userstory\ComponentMigration\models\db\Migration::relationClass|relationClass]]``, определяющее имя класса связанного с данной миграцией. 
Если это свойство задать - свойство ``[[Userstory\ComponentMigration\models\db\Migration::tableName|tableName]]`` задается автоматически (в случае, если не задано вручную).

 3. Добавлена реализация метода ``[[Userstory\ComponentMigration\models\db\Migration::safeDown()|safeDown()]]``, который удаляет таблицу, связанную с данной миграцией.
  
 4. Добавлен метод ``[[Userstory\ComponentMigration\models\db\Migration::addForeignKeyWithSuffix()|addForeignKeyWithSuffix()]]``. Этот метод переопределяет поведение родительского, добавляя суффиксы для таблиц, внешних ключей и т.п.
 
 5. Добавлен метод ``[[Userstory\ComponentMigration\models\db\Migration::addForeignKeyForModifiers()|addForeignKeyForModifiers()]]``, который регистрирует вторичные ключи для связи с профилем создающего и изменяющего, а также обратный метод ``[[Userstory\ComponentMigration\models\db\Migration::dropForeignKeyForModifiers()|dropForeignKeyForModifiers()]]``.
  
 6. Добавлен метод ``[[Userstory\ComponentMigration\models\db\Migration::addPrimaryKeyWithSuffix()|addPrimaryKeyWithSuffix()]]``, который добавляет первичный ключ в таблюцу, формируя суфикс по названию таблицы и столбцов.
 
 7. Добавлен метод ``[[Userstory\ComponentMigration\models\db\Migration::addIndex()|addIndex()]]``, который добавляет индекс в таблицу, формируя суфикс по названию таблицы и столбцов.
 
 8. Добавлен метод ``[[Userstory\ComponentMigration\models\db\Migration::addCommentToTable()|addCommentToTable()]]``, который добавляет комментарий к таблице.
 
 9. Добавлен метод добавления прав на роль ``addPermissionOnRole()``.
 Для его использования нужно переопределить новое свойство класса:
     ```php
    protected $permissionRoleList = [
            'ExampleRole1' => [
                'ExamplePermission1' => ExampleIsGlobal1,
                'ExamplePermission2' => ExampleIsGlobal2,
                'ExamplePermission3' => ExampleIsGlobal1,
                'ExamplePermission4' => ExampleIsGlobal1,
            ],
            'ExampleRole2' => [
                'ExamplePermission1' => ExampleIsGlobal1,
                'ExamplePermission2' => ExampleIsGlobal2,
            ],
        ];
    ```
