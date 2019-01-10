<?php

namespace Userstory\ComponentBase\models;

use Userstory\ComponentBase\interfaces\ObjectMakerInterface;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Класс ModelFactory.
 * Класс, позволяющий создавать объекты.
 *
 * @package Userstory\ComponentBase\models
 */
class ModelsFactory extends Component
{
    const MODEL_CONFIG_LIST_KEY             = 'modelConfigList';
    const OBJECT_MAKER_PROTOTYPE_CONFIG_KEY = 'objectMakerConfig';
    const OBJECT_TYPE_KEY                   = 'type';
    const OBJECT_PARAMS_KEY                 = 'params';

    /**
     * Конфиг объекта, выполняющего создание объектов через Yii::createObject(...).
     *
     * @var array
     */
    protected $objectMakerConfig = [
        'class' => ObjectMaker::class,
    ];

    /**
     * Объект, выполняющий создание объектов через Yii::createObject(...).
     *
     * @var ObjectMakerInterface|null
     */
    protected $objectMakerPrototype;

    /**
     * Список моделей, и их конфигураций, которые может создавать фабрика.
     *
     * @var array
     */
    protected $modelConfigList = [];

    /**
     * Кеш созданых объектов моделей.
     *
     * @var array
     */
    protected $modelInstanceCache = [];

    /**
     * Устанавливаем значение для атрибута.
     *
     * @param array $value значение для атрибута.
     *
     * @return static
     */
    public function setModelConfigList(array $value)
    {
        $this->modelConfigList = $value;
        return $this;
    }

    /**
     * Метод устанавливает конфиг, для создания объекта, выполняющего создание объектов через Yii::createObject(...).
     *
     * @param array $config Новое значение.
     *
     * @return $this
     */
    public function setObjectMakerConfig(array $config)
    {
        $this->objectMakerConfig = $config;
        return $this;
    }

    /**
     * Метод для получения объекта, выполняющего создание объектов через Yii::createObject(...).
     *
     * @return ObjectMakerInterface
     *
     * @throws InvalidConfigException Исключение генерируется если объект сконфигурирован неверно.
     */
    public function getObjectMakerPrototype()
    {
        if ($this->objectMakerPrototype) {
            return $this->objectMakerPrototype;
        }
        $prototype = Yii::createObject($this->objectMakerConfig);
        if (! $prototype instanceof ObjectMakerInterface) {
            throw new InvalidConfigException(get_class($prototype) . ' must implement ' . ObjectMakerInterface::class);
        }
        $this->objectMakerPrototype = $prototype;
        return $this->objectMakerPrototype;
    }

    /**
     * Метод для установки объекта, выполняющего создание объектов через Yii::createObject(...).
     *
     * @param ObjectMakerInterface $objectCreator Новое значение.
     *
     * @return $this
     */
    public function setObjectMakerPrototype(ObjectMakerInterface $objectCreator)
    {
        $this->objectMakerPrototype = $objectCreator;
        return $this;
    }

    /**
     * Метод создает объект из конфигурации, хранящейся по ключу $modelKey в списке конфигураций фабрики.
     *
     * @param string  $modelKey             Ключ, по которому храниться конфигурация интересующего объекта.
     * @param array   $additionalObjectType Дополнительные данные, которыми будет дополнен конфиг объекта.
     * @param boolean $allowCache           Можно ли брать объекты из кеша, если они в нем есть.
     *
     * @return mixed
     *
     * @throws InvalidConfigException Исключение генерируется, если есть проблемы с конфигурацией интересующей модели.
     */
    public function getModelInstance($modelKey, array $additionalObjectType = [], $allowCache = true)
    {
        if ($allowCache && array_key_exists($modelKey, $this->modelInstanceCache)) {
            return $this->modelInstanceCache[$modelKey];
        }

        if (! array_key_exists($modelKey, $this->modelConfigList)) {
            throw new InvalidConfigException('По указанному ключу отсутствует конфигурация модели в списке конфигураций');
        }

        $basicObjectType = $this->getObjectType($this->modelConfigList[$modelKey]);
        $objectType      = $this->mergeObjectType($basicObjectType, $additionalObjectType);
        $objectParams    = $this->getObjectParams($this->modelConfigList[$modelKey]);
        $objectMaker     = $this->getObjectMakerPrototype()->copy();
        $objectMaker->setType($objectType);
        $objectMaker->setParams($objectParams);
        $this->modelInstanceCache[$modelKey] = $objectMaker->create();
        return $this->modelInstanceCache[$modelKey];
    }

    /**
     * Метод выполняет слияние базового конфига создаваемого объекта и части конфига, присланной в рантайме.
     *
     * @param mixed $basicObjectType      Базовая часть конфига.
     * @param array $additionalObjectType Часть объекта массива из рантайма.
     *
     * @return array
     */
    protected function mergeObjectType($basicObjectType, array $additionalObjectType)
    {
        if (! is_array($basicObjectType)) {
            $basicObjectType = ['class' => $basicObjectType];
        }
        return ArrayHelper::merge($basicObjectType, $additionalObjectType);
    }

    /**
     * Метод получает конфиг для создания объекта из настроек, указанных для его создания.
     *
     * @param array $objectSettings Настройки для создания обхекта.
     *
     * @return mixed
     *
     * @throws InvalidConfigException Исключение генерируется в случае, если конфигурация не указана в настройках.
     */
    protected function getObjectType(array $objectSettings)
    {
        if (! array_key_exists(self::OBJECT_TYPE_KEY, $objectSettings)) {
            throw new InvalidConfigException('Конфигурация объекта не содержит в себе обязательный ключ ' . self::OBJECT_TYPE_KEY);
        }
        return $objectSettings[self::OBJECT_TYPE_KEY];
    }

    /**
     * Метод получает параметры для создания объекта из настроек, указанных для его создания.
     *
     * @param array $objectSettings Настройки для создания обхекта.
     *
     * @return mixed
     */
    protected function getObjectParams(array $objectSettings)
    {
        if (! array_key_exists(self::OBJECT_PARAMS_KEY, $objectSettings)) {
            return [];
        }
        return (array)$objectSettings[self::OBJECT_PARAMS_KEY];
    }
}
