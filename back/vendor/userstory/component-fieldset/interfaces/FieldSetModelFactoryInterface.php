<?php

namespace Userstory\ComponentFieldset\interfaces;

use yii\base\InvalidConfigException;
use yii\db\ActiveQueryInterface;

/**
 * Interface ModelFieldSetInterface
 * Интерфейс формирования фабрики для работы компонента работы с динамическими формами.
 *
 * @package Userstory\ComponentFieldset\factories
 */
interface FieldSetModelFactoryInterface
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
    public function getFieldSetQuery(array $additionalObjectType = []);

    /**
     * Получение класса построителя запросов для параметров динамических форм.
     *
     * @param array $additionalObjectType Дополнительные данные, которыми будет дополнен конфиг объекта.
     *
     * @return ActiveQueryInterface
     *
     * @throws InvalidConfigException Исключение генерируется, если есть проблемы с конфигурацией интересующей модели.
     */
    public function getFieldSettingQuery(array $additionalObjectType = []);
}
