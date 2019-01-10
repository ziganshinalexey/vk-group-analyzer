[Назад](/README.md)
## Фабрики объектов
Текущая архитектура типового пакета в компании на данный момент следующая:
существует единая точка входа в систему, которую представляет пакет.
Эта точка входа называется компонентом. Компонент конфигурируется в конфиге примерно
следующим образом:

```php
return [

    ...
    
    'components' => [
        'system1'         => [
            'class'        => System1Component::class,
            ...
            // вся остальная конфигурация компонента.
            ...
        ],
        
        ...
        
    ];
```

Существует необходимость конфигурировать и порождать объекты, 
которыми оперирует подсистема. Для этих целей предлагается 
использовать функционал фабрик, о котором пойдет речь ниже.

### Трейт ModelsFactoryTrait

Обычно компоненту пакета необходима только одна фабрика 
для порождения объектов.

Для реализации этого типового функционала предлагается использовать интерфес:
```
Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface
```
и трейт:
```
Userstory\ComponentBase\traits\ModelsFactoryTrait
```
Интерфейс обязует имплементирующие его класс иметь методы для 
установки конфига фабрики, получения и установки объекта фабрики.
Трейт в свою очередь добавляет к объекту, к которому он подключен,
реализацию этих методов по умолчанию:
                                  
```php

    /**
     * Конфигурация фабрики моделей.
     *
     * @var array
     */
    protected $modelFactoryConfig = [ ... ];
    
    /**
     * Метод позволяет установить конфигурацию фабрики моделей.
     *
     * @param array $value Конфигурация фабрики моделей.
     *
     * @return static
     */
    public function setModelFactoryConfig(array $value)
    {
      ...
    }
    
    /**
     * Метод позволяет получить фабрику моделей.
     *
     * @return ModelsFactory
     *
     * @throws InvalidConfigException Исключение генерируется в случае 
                                      неверной конфигурации фабрики моделей.
     */
    public function getModelFactory()
    {
        ...
    }

```
Обратите внимание что метод getModelFactory возвращает экземпляр класса 
```
Userstory\ComponentBase\models\ModelsFactory
```
или его производных. Это нужно помнимть при конфигурации фабрики в конфиге.

### Подключение и конфигурация функционала фабрики

Вернемся к нашему примеру с компонентом для системы1. Подключим к нему функционал фабрики:

```php

    class System1Component extends Component
    {
        use ModelsFactoryTrait;    
        ...
    }

```

Теперь конфиг компонента может выглядеть следующим образом:
```php
return [

    ...
    
    'components' => [
        'system1'         => [
            'class'        => System1Component::class,
            ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
                'class'           => ModelsFactory::class,
                ModelsFactory::MODEL_CONFIG_LIST_KEY => [
                    '### ObjectClass1Key ###' => [
                        ModelsFactory::OBJECT_TYPE_KEY   => ObjectClass1::class,
                        ModelsFactory::OBJECT_PARAMS_KEY => [...],
                    ],
                    ...                    
                ],
            ],
            ...
            // вся остальная конфигурация компонента.
            ...
        ],
        
        ...
        
    ];
```

- По ключу ComponentWithFactoryInterface::FACTORY_CONFIG_KEY в конфиге компонента
храниться конфиг фабрики.
    - В конфиге фабрики по ключу ModelsFactory::MODEL_CONFIG_LIST_KEY
храниться список конфигов объектов, которые порождает фабрика. 
Данный список представляет собой массив, ключами которого являются
произвольные идентификаторы порождаемых объектов, а значениями - их конфиг.
Конфиг объекта представляет из себя массив, состоящих из двух элементов:
        - по ключу ModelsFactory::OBJECT_TYPE_KEY храниться значение, которое будет передано в качестве параметра $type в метод Yii::createObject(). Именно он используется для создания объектов. 
        - по ключу ModelsFactory::OBJECT_OBJECT_PARAMS_KEY храниться значение, которое будет передано в качестве параметра $params в метод Yii::createObject().

### Порождение объекта

Как получить сконфигурированный объект при помощи фабрики? Очень просто.
В рамках нашеого примера это будет выглядеть следующим образом:

```php
$object1 = Yii::$app->system1->modelFactory->getModelInstance('### ObjectClass1Key ###');
```

### Расширение функционала фабрики

Выше описаный пример порождения объекта не очень красивый.
Хотелось бы, чтобы он выглядел следующим образом:

```php
$object1 = Yii::$app->system1->modelFactory->getObject1();
```

Для этих целей реализуем класс System1ModelsFactory унаследованный от ModelsFactory:

```php

class System1ModelsFactory extends ModelsFactory
{
    ...
    
    /**
     * Метод получает объект1.
     *
     * @return ObjectClass1
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getObject1()
    {
        $result = $this->getModelInstance('### ObjectClass1Key ###');
        if (! $result instanceof ObjectClass1) {
            throw new InvalidConfigException('Класс возвращаемого объекта должен быть производной от ' . ObjectClass1::class);
        }
        return $result;
    }
    
    ...
    
}

```

Теперь поменяем конфиг компонента, чтобы использовать новый класс фабрики:
```php
return [

    ...
    
    'components' => [
        'system1'         => [
            'class'        => System1Component::class,
            ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
                'class'           => System1ModelsFactory::class,
                ModelsFactory::MODEL_CONFIG_LIST_KEY => [
                    '### ObjectClass1Key ###' => [
                        ModelsFactory::OBJECT_TYPE_KEY   => ObjectClass1::class,
                        ModelsFactory::OBJECT_PARAMS_KEY => [...],
                    ],
                    ...                    
                ],
            ],
            ...
            // вся остальная конфигурация компонента.
            ...
        ],
        
        ...
        
    ];
```
Теперь вызов
```php
$object1 = Yii::$app->system1->modelFactory->getObject1();
```
будет работать. Кроме того, метод будет гарантировано возвращать объект нужного 
класса, что исключает ошибки конфигурации.

[Назад](/README.md)