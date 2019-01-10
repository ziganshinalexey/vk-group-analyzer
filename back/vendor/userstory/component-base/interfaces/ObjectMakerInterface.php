<?php

namespace Userstory\ComponentBase\interfaces;

/**
 * Интерфейс ObjectMakerInterface.
 * Интерфейс объекта, в который завернуто выполнение опреации Yii::createObject(...).
 *
 * @package Userstory\ComponentBase\interfaces
 */
interface ObjectMakerInterface extends PrototypeInterface
{
    /**
     * Метод устанавливает параметр type метода Yii::createObject(...).
     *
     * @param mixed $type Новое значение.
     *
     * @return $this
     */
    public function setType($type);

    /**
     * Метод устанавливает параметр params метода Yii::createObject(...).
     *
     * @param mixed $params Новое значение.
     *
     * @return $this
     */
    public function setParams($params);

    /**
     * Метод выполняет создание объекта в соответствии с выставленной конфигурацией.
     *
     * @return mixed
     */
    public function create();
}
