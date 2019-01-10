<?php

namespace Userstory\ComponentBase\traits;

/**
 * Trait ComponentModelsTrait.
 * Трейт для операций с моделями компонента.
 *
 * @property array $modelClasses
 *
 * @package Userstory\ComponentBase\traits
 */
trait ComponentModelsTrait
{
    /**
     * Список моделей, с которыми работает текущий компонент.
     *
     * @var array
     */
    protected $modelClasses = [];

    /**
     * Сеттер задает список моделей.
     *
     * @param array $models Список моделей.
     *
     * @return static
     */
    public function setModelClasses(array $models)
    {
        $this->modelClasses = $models;
        return $this;
    }

    /**
     * Геттер возвращает список моделей.
     *
     * @return array
     */
    public function getModelClasses()
    {
        return $this->modelClasses;
    }
}
