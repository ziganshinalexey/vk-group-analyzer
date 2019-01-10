<?php

namespace Userstory\User\factories;

use Userstory\ComponentBase\models\Model;
use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\User\interfaces\UserProfileSearchFactoryInterface;
use yii\base\InvalidConfigException;
use yii\db\ActiveQueryInterface;

/**
 * Class ModelUserProfileSearchFactory.
 * Фабрика построителя запроса поиска профиля пользователя.
 *
 * @package Userstory\User\factories
 */
class ModelUserProfileSearchFactory extends ModelsFactory implements UserProfileSearchFactoryInterface
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
    public function getUserProfileQuery(array $additionalObjectType = [])
    {
        $class = $this->getModelInstance('userProfileQuery', $additionalObjectType, false);

        if (! $class instanceof ActiveQueryInterface) {
            throw new InvalidConfigException('Класс возвращаемого объекта должен быть производной от ' . ActiveQueryInterface::class);
        }

        return $class;
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
        if (! ArrayHelper::getValue($additionalObjectType, 'userProfileQuery', false)) {
            $additionalObjectType['userProfileQuery'] = $this->getUserProfileQuery();
        }

        $class = $this->getModelInstance('userProfileSearch', $additionalObjectType, false);

        if (! $class instanceof Model) {
            throw new InvalidConfigException('Класс возвращаемого объекта должен быть производной от ' . Model::class);
        }

        return $class;
    }
}
