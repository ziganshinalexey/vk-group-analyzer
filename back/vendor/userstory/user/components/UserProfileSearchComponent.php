<?php

namespace Userstory\User\components;

use Userstory\ComponentBase\traits\ModelsFactoryTrait;
use Userstory\User\interfaces\UserProfileSearchFactoryInterface;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\ActiveQueryInterface;

/**
 * Class UserProfileSearchComponent.
 * Компонент для поиска профиля пользователя.
 *
 * @package Userstory\User\components
 */
class UserProfileSearchComponent extends Component
{
    use ModelsFactoryTrait {
        getModelFactory as getModelFactoryFromTrait;
    }

    /**
     * Метод получает фабрику моделей для компонента метрик.
     *
     * @return UserProfileSearchFactoryInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случе неверной конфигурации фабрики моделей.
     */
    public function getModelFactory()
    {
        $modelFactory = $this->getModelFactoryFromTrait();
        if (! $modelFactory instanceof UserProfileSearchFactoryInterface) {
            throw new InvalidConfigException('Фабрика моделей должна имплементировать интерфейс ' . UserProfileSearchFactoryInterface::class);
        }
        return $modelFactory;
    }

    /**
     * Получение класса построителя запросов для динамических форм.
     *
     * @param array $additionalObjectType Дополнительные данные, которыми будет дополнен конфиг объекта.
     *
     * @return ActiveQueryInterface
     *
     * @throws InvalidConfigException Исключение генерируется, если есть проблемы с конфигурацией интересующей модели.
     */
    public function getUserProfileQuery(array $additionalObjectType = [])
    {
        return $this->getModelFactory()->getUserProfileQuery($additionalObjectType);
    }

    /**
     * Получение класса построителя для модели поиска профиля пользователя.
     *
     * @param array $additionalObjectType Дополнительные данные, которыми будет дополнен конфиг объекта.
     *
     * @return Model
     *
     * @throws InvalidConfigException Исключение генерируется, если есть проблемы с конфигурацией интересующей модели.
     */
    public function getUserProfileSearchModel(array $additionalObjectType = [])
    {
        return $this->getModelFactory()->getUserProfileSearchModel($additionalObjectType);
    }
}
