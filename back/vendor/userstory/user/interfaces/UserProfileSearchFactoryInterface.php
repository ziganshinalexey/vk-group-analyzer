<?php

namespace Userstory\User\interfaces;

use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveQueryInterface;

/**
 * Interface UserProfileSearchFactoryInterface
 * Интерфейс фабрики построителя запроса поиска профиля пользователя.
 *
 * @package Userstory\User\interfaces
 */
interface UserProfileSearchFactoryInterface
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
    public function getUserProfileQuery(array $additionalObjectType = []);

    /**
     * Получение класса построителя для модели поиска профиля пользователя.
     *
     * @param array $additionalObjectType Дополнительные данные, которыми будет дополнен конфиг объекта.
     *
     * @return Model
     *
     * @throws InvalidConfigException Исключение генерируется, если есть проблемы с конфигурацией интересующей модели.
     */
    public function getUserProfileSearchModel(array $additionalObjectType = []);
}
