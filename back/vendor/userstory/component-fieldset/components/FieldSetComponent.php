<?php

namespace Userstory\ComponentFieldset\components;

use Userstory\ComponentBase\traits\ModelsFactoryTrait;
use Userstory\ComponentFieldset\interfaces\FieldSetModelFactoryInterface;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 * Class FieldSetComponent.
 * Компонент для работы с динамическими формами.
 *
 * @package Userstory\ComponentFieldset\components
 */
class FieldSetComponent extends Component
{
    use ModelsFactoryTrait {
        getModelFactory as getModelFactoryFromTrait;
    }

    /**
     * Метод получает фабрику моделей для компонента метрик.
     *
     * @return FieldSetModelFactoryInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случе неверной конфигурации фабрики моделей.
     */
    public function getModelFactory()
    {
        $modelFactory = $this->getModelFactoryFromTrait();
        if (! $modelFactory instanceof FieldSetModelFactoryInterface) {
            throw new InvalidConfigException('Фабрика моделей должна имплементировать интерфейс ' . FieldSetModelFactoryInterface::class);
        }
        return $modelFactory;
    }

    /**
     * Получение класса построителя запросов для динамических форм.
     *
     * @param array $additionalObjectType Дополнительные данные, которыми будет дополнен конфиг объекта.
     *
     * @return \yii\db\ActiveQueryInterface
     * @throws InvalidConfigException Исключение генерируется, если есть проблемы с конфигурацией интересующей модели.
     */
    public function getFieldSetQuery(array $additionalObjectType = [])
    {
        return $this->getModelFactory()->getFieldSetQuery($additionalObjectType);
    }

    /**
     * Получение класса построителя запросов для параметров динамических форм.
     *
     * @param array $additionalObjectType Дополнительные данные, которыми будет дополнен конфиг объекта.
     *
     * @return \yii\db\ActiveQueryInterface
     * @throws InvalidConfigException Исключение генерируется, если есть проблемы с конфигурацией интересующей модели.
     */
    public function getFieldSettingQuery(array $additionalObjectType = [])
    {
        return $this->getModelFactory()->getFieldSettingQuery($additionalObjectType);
    }
}
