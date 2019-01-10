### Описание модуля
Компонент создан для создания динамических форм и хранения некоторых не связанных свойств модели.
Данные хранятся в JSON формате в базе данных. Позволяет не меняя структуры таблицы хранить набор данных.

### Установка
```
composer require userstory/component-fieldset dev-master
```

### Основые классы и модели

##### Fieldset
Модель, запись информации о филдсете.

##### FieldSetting
Модель, запись иформации о полях филдсета. Содержит основную информацию о хранимых филдсетом данных, 
таких как название поля, описание, правила валидации, заголовок поля.

##### AbstractFieldset
Абстрактный класс для базового функционала филдсета. 
Содержит описания основного набора полей используемых для хранения данных филдсета.
Реализует методы ActiveRecord для работы с дополнительными полями, как с обычными.
Набор базовых полей для данной модели: 

```
'fieldsetPk' => $this->primaryKey(), 
'relationId' => $this->integer()->notNull(), // идентификатор связанной сущности.
'fieldsetId' => $this->integer()->notNull(), // идентификатор филдсета.
'dataJson'   => 'JSON', // хранимые данные.
'creatorId'  => $this->integer(), 
'createDate' => $this->dateTimeWithTZ()->notNull()->defaultExpression('NOW()'),
'updaterId'  => $this->integer(),
'updateDate' => $this->dateTimeWithTZ(),
```
 
##### FieldRuleTrait
Трэйт для описания правил валидации и хранения их в базе. Используется внутри миграции.
Правила в базе хранятся в виде сериализованных JSON объектов. 
Правила описываются также как и в методе Rules, за исключением осутсвия списка полей в начале.
 
### Как использовать

1. Создать модель расширяющую AbstractFieldset.
2. Переопределить метод getFieldsetName().
3. Создать объект филдсета в базе (Userstory\ComponentFieldset\entities\Fieldset).
4. Создать описания полей в базе (Userstory\ComponentFieldset\entities\FieldSetting).
5. Если необходимо создать неспосредственно таблицу для хранения данных.
6. Определить связи с другими объектами.
7. Переопределить геттеры связаных объектов для автоматического создания объекта филдсета если необходимо.

#### Пример использования

шаги 1, 2, 6. Создим модель. Например настройки пользователя.
```
/**
* @property boolean $isSendMessages
*/
class UserSettings extends AbstractFieldset
{
    // Название филдсета.
    public function getFieldsetName() {
        return 'user_settings';
    }
    // Имя таблицы филдсета, в данном случае отдельная таблица.
    public static function tableName() {
        return '{{%user_settings}}';
    }
    // Объявление связи с профилем
    public function getProfile() {
        return $this->hasOne(UserProfile::class, ['id' => 'relationId'])->inverseOf('settings');
    }
}
```

шаги 3-5. Создание таблиц.

```
use FieldRuleTrait;

...

$tableName          = UserSettings::tableName();
$fieldsetTable      = Fieldset::tableName();
$fieldSettingsTable = FieldSetting::tableName();
$fieldsetName       = (new UserSettings())->getFieldsetName();
$profileTable       = UserProfile::tableName();

...
\\ Шаг 3.
$this->insert( $this->fieldsetTable, [
    'name'        => $fieldsetName,
    'caption'     => 'Дополнительные свойства профиля пользователя',
]);
\\ Сохраним ключ для вставки полей.
$fieldsetPk = $this->db->getLastInsertID(Fieldset::getTableSchema()->sequenceName);

\\ Шаг 4. Добавим поля.
$this->batchInsert($this->fieldSettingsTable, [
    'fieldsetId',
    'name',
    'label',
    'rulesJson',
], [
    [
        $fieldsetPk,
        'isSendMessages',
        'Отправлять сообщения пользователю',
        // Методы из FieldRuleTrait.
        $this->encode(array_merge($this->getDefaultRule(1), $this->getIntFilterRule())),
    ],
]);

\\ Шаг 5.
$this->createTable($this->tableName, [
    'fieldsetPk' => $this->primaryKey(),
    'relationId' => $this->integer()->notNull(),
    'fieldsetId' => $this->integer()->notNull(),
    'dataJson'   => 'JSON',
    'creatorId'  => $this->integer(),
    'createDate' => $this->dateTimeWithTZ()->notNull()->defaultExpression('NOW()'),
    'updaterId'  => $this->integer(),
    'updateDate' => $this->dateTimeWithTZ(),
], $this->getTableOptions(['COMMENT' => 'Таблица настроек профиля пользователя.']));

$this->addIndex($this->tableName, ['relationId', 'fieldsetId'], true);

$this->addForeignKeyWithSuffix($this->tableName,
    'fieldsetId',
    $fieldsetTable,
    'id',
    'CASCADE',
    'CASCADE');

$this->addForeignKeyWithSuffix($tableName,
    'relationId',
    $profileTable,
    'id',
    'CASCADE',
    'CASCADE');
```

Шаг 7. Переопределим геттер в связанной модели и пропишем связь.
```
/**
 * @property UserSettings $settings
 */
class UserProfile extends ActiveRecord
{

...

    public function __get($name) {
        $value = parent::__get($name);
        if (null !== $value) {
            return $value;
        }

        switch (strtolower($name)) {
            case 'settings':
                $fieldset = new UserSettings();
                $fieldset->relationId = $this->id;
                $fieldset->save();
                $this->populateRelation('settings', $fieldset);
                $fieldset->populateRelation('profile', $this);
                return $fieldset;
        }

        return $value;
    }
    
    public function getSettings() {
        return $this->hasOne(UserSettings::class, ['relationId' => 'id'])->inverseOf('profile');
    }

...

}
```

Шаг 8. Profit...
```
$profile = UserProfile::findOne(123);
$profile->settings->isSendMessages = 1;
$profile->settings->save();

```