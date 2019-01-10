<?php

namespace Userstory\User\traits;

use Userstory\User\components\UserComponent;
use Userstory\User\models\ResultModel;
use yii;
use yii\db\Expression;
use yii\db\Query;

/**
 * Trait FactoryCommonTrait.
 * Трейт для базовых операций по созданию частоиспользуемых объектов.
 *
 * @package Userstory\User\traits
 */
trait FactoryCommonTrait
{
    /**
     * Метод возвращает объект построителя запросов.
     *
     * @return Query
     */
    protected function getQueryObject()
    {
        /* @var UserComponent $component */
        $component = Yii::$app->userBase;
        return $component->modelFactory->getQueryObject();
    }

    /**
     * Метод возвращает объект БД выражения.
     *
     * @param array|string $config Конфигурация для работы.
     *
     * @return Expression
     */
    protected function getExpression($config)
    {
        if (is_string($config)) {
            $config = ['expression' => $config];
        }

        $config = (array)$config;

        /* @var UserComponent $component */
        $component = Yii::$app->userBase;
        return $component->modelFactory->getExpression($config);
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
        /* @var UserComponent $component */
        $component = Yii::$app->userBase;
        return $component->modelFactory->getResult($config);
    }
}
