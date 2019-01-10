<?php

namespace Userstory\ComponentApiServer\traits;

use Userstory\ComponentApiServer\actions\AbstractApiAction;
use Userstory\ComponentHelpers\helpers\ArrayHelper;

/**
 * Трэит GetterSetterTrait костыль для сокращение строк в главном компоненте.
 *
 * @package Userstory\ComponentApiServer\traits
 */
trait GetterSetterTrait
{
    /**
     * Метод задает значение для списка особых апи действий.
     *
     * @param array $value Новое значение.
     *
     * @return void
     */
    public function setSpecialActionList(array $value)
    {
        $this->specialActionList = ArrayHelper::merge($this->specialActionList, $value);
    }

    /**
     * Метод возвращает значение списка особых апи действий.
     *
     * @return array
     */
    public function getSpecialActionList()
    {
        return $this->specialActionList;
    }

    /**
     * Метод устанавливает новое значение для метода по-умолчанию.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setDefaultMethod($value)
    {
        $this->defaultMethod = $value;
    }

    /**
     * Метод возвращает название метода по-умолчанию.
     *
     * @return string
     */
    public function getDefaultMethod()
    {
        return $this->defaultMethod;
    }

    /**
     * Метод возвращает хеддеры по-умолчанию.
     *
     * @return array|null
     */
    public function getDefaultHeaders()
    {
        return $this->defaultHeaders;
    }

    /**
     * Метод задает значение хеддеры по-умолчанию.
     *
     * @param array $value Новое значение.
     *
     * @return void
     */
    public function setDefaultHeaders(array $value)
    {
        $this->defaultHeaders = $value;
    }

    /**
     * Метод возвращает версию текущего протокола.
     *
     * @return string
     */
    public function getProtocolVersion()
    {
        return '1.0';
    }

    /**
     * Метод задает активный экшен.
     *
     * @param AbstractApiAction $action Экшн для сохранения.
     *
     * @return static
     */
    public function setAction(AbstractApiAction $action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * Метод возвращает активный экшен.
     *
     * @return AbstractApiAction
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Сеттер для установки api паттерна перехвата запросов.
     *
     * @param string $pattern Паттерн для установки.
     *
     * @return static
     */
    public function setApiPattern($pattern)
    {
        $this->apiPattern = $pattern;

        return $this;
    }

    /**
     * Геттер для возврата api паттерна перехвата запросов.
     *
     * @return string
     */
    public function getApiPattern()
    {
        return $this->apiPattern;
    }

    /**
     * Сеттер для установки возможный API действий.
     *
     * @param array $actions Действия для установки.
     *
     * @return static
     */
    public function setActions(array $actions = [])
    {
        $this->actions = ArrayHelper::merge($this->actions, $actions);

        return $this;
    }

    /**
     * Геттер возвращает список доступных API действий.
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }
}
