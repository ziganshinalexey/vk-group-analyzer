<?php

namespace Userstory\ComponentFieldset\factories;

use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\ComponentFieldset\interfaces\FieldSetModelFactoryInterface;
use yii\base\InvalidConfigException;
use yii\db\ActiveQueryInterface;

/**
 * Class ModelFieldSetFactory.
 * Фабрика формирования сконфигурированого класса для работы с динамическими формами.
 *
 * @package Userstory\ComponentFieldset\factories
 */
class ModelFieldSetFactory extends ModelsFactory implements FieldSetModelFactoryInterface
{
    /**
     * Получение класса построителя запросов для динамических форм.
     *
     * @param array $additionalObjectType Дополнительные данные, которыми будет дополнен конфиг объекта.
     *
     * @return ActiveQueryInterface
     *
     * @throws InvalidConfigException Исключение генерируется, если есть проблемы с конфигурацией интересующей модели.
     */
    public function getFieldSetQuery(array $additionalObjectType = [])
    {
        $class = $this->getModelInstance('fieldSetQuery', $additionalObjectType, false);
        if (! $class instanceof ActiveQueryInterface) {
            throw new InvalidConfigException('Класс возвращаемого объекта должен быть производной от ' . ActiveQueryInterface::class);
        }
        return $class;
    }

    /**
     * Получение класса построителя запросов для параметров динамических форм.
     *
     * @param array $additionalObjectType Дополнительные данные, которыми будет дополнен конфиг объекта.
     *
     * @return ActiveQueryInterface
     *
     * @throws InvalidConfigException Исключение генерируется, если есть проблемы с конфигурацией интересующей модели.
     */
    public function getFieldSettingQuery(array $additionalObjectType = [])
    {
        $class = $this->getModelInstance('fieldSettingQuery', $additionalObjectType, false);
        if (! $class instanceof ActiveQueryInterface) {
            throw new InvalidConfigException('Класс возвращаемого объекта должен быть производной от ' . ActiveQueryInterface::class);
        }
        return $class;
    }
}
