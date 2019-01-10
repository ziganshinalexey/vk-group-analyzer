[Назад](/README.md)
Класс `Userstory\ComponentBase\caches\AbstractCache` Реализует методы кеширование моделей по условиям выборки построителя запросов.
Сделано для того чтобы можно было кешировать результат выполнения операций получения моделей.
При инициализации объекта кеша необходимо указать префикс для имени кеша (можно через через фабрику).
```php
ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
    'class'                            => ModelsFactory::class,
    ModelsFactory::MODEL_CONFIG_LIST_KEY => [
        ...
        ModelsFactory::LANGUAGE_CACHE_MODEL         => [
            ModelsFactory::OBJECT_TYPE_KEY => [
                'class'          => AbstractCache::class,
                'cacheKeyPrefix' => 'i18n-language',
            ],
        ],
        ...
    ],
],
```
Также кеш работает только с моделями данных, которые реализуют методы интерфейса `Userstory\ComponentBase\interfaces\DataModelInterface`
Для этого необходимо задать свойства `Userstory\ComponentBase\caches\AbstractCache`.
```php
    /**
     * Свойство хранит объект гидратора.
     *
     * @var HydratorInterface|null
     */
    protected $hydrator;

    /**
     * Свойство хранит объект для преобразования данных.
     *
     * @var DataModelInterface|null
     */
    protected $modelInstance;
```
От `$modelInstance` будут производится копии и гидрироватся.
К самой операции получения необходимо добавить свойство для хранения объекта кеша.
Для того чтобы закешировать результат выполнения операции, необходимо вызвать метод `setToCache(array $condition, array $value, $isMany = false)`.
Про каждый из параметров можно прочитать в интерфейсе класса или в самом классе.
Данные которые нужно положить в кеш должны быть массивом, соответственно назад из кеша всегда будет возвращаться массив.
Протухшие данные можно чистить через:
1. `public function flush()`;
2. `public function clearCacheByModel(ActiveRecordInterface $model)`.
Первый метод очищает кеш с префиксом объекта кеша.
Второй метод очищает кеш по модели ActiveRecord'а. После сохранения модели ищутся определенные ключи, где может находиться такая модель и удаляются.
[Назад](/README.md)