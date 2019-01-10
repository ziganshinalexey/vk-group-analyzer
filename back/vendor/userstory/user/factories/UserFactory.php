<?php

namespace Userstory\User\factories;

use Userstory\ComponentBase\models\ModelsFactory as BaseFactory;
use Userstory\User\models\ResultModel;
use yii\base\Event;
use yii\db\Expression;
use yii\db\Query;

/**
 * Class UserFactory.
 * Класс фабрики для создания объектов.
 *
 * @package Userstory\User\factories
 */
class UserFactory extends BaseFactory
{
    /**
     * Метод возвращает объект построителя запросов.
     *
     * @param array $config Конфигурация для работы.
     *
     * @return Query
     */
    public function getQueryObject(array $config = [])
    {
        return $this->getModelInstance('queryObject', $config, false);
    }

    /**
     * Метод возвращает объект события.
     *
     * @param array $config Конфигурация для работы.
     *
     * @return Event
     */
    public function getEvent(array $config = [])
    {
        return $this->getModelInstance('event', $config, false);
    }

    /**
     * Метод возвращает объект БД выражения.
     *
     * @param array $config Конфигурация для работы.
     *
     * @return Expression
     */
    public function getExpression(array $config = [])
    {
        return $this->getModelInstance('expression', $config, false);
    }

    /**
     * Метод возвращает объект результата.
     *
     * @param array $config Конфигурация для работы.
     *
     * @return ResultModel
     */
    public function getResult(array $config = [])
    {
        return $this->getModelInstance('result', $config, false);
    }
}
