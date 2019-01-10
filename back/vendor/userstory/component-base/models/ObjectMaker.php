<?php

namespace Userstory\ComponentBase\models;

use Userstory\ComponentBase\interfaces\ObjectMakerInterface;
use yii;

/**
 * Класс ObjectCreator.
 * Класс для создания объектов при помощи их конфига через Yii::createObject(...).
 *
 * @package Userstory\ComponentBase\models
 */
class ObjectMaker implements ObjectMakerInterface
{
    /**
     * Параметр type передающийся в метод Yii::createObject(...) для создания объекта.
     *
     * @var mixed|null
     */
    protected $type;

    /**
     * Параметр params передающийся в метод Yii::createObject(...) для создания объекта.
     *
     * @var mixed|null
     */
    protected $params;

    /**
     * Метод устанавливает параметр type метода Yii::createObject(...).
     *
     * @param mixed $type Новое значение.
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Метод устанавливает параметр params метода Yii::createObject(...).
     *
     * @param mixed $params Новое значение.
     *
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Метод выполняет создание объекта в соответствии с выставленной конфигурацией.
     *
     * @return mixed
     */
    public function create()
    {
        return Yii::createObject($this->type, $this->params);
    }

    /**
     * Метод копирует текущий объект.
     *
     * @return static
     */
    public function copy()
    {
        $result = new static();
        $result->setType($this->type);
        $result->setParams($this->params);
        return $result;
    }
}
