<?php

namespace Userstory\ComponentBase\traits;

/**
 * Trait DynamicModelTrait.
 * Трейт добавляет возможность работы с динамическими моделями.
 *
 * @package Userstory\ComponentBase\traits
 */
trait DynamicModelTrait
{
    /**
     * Свойство содержит список динамических атрибутов модели.
     *
     * @var array
     */
    protected $dynamicAttributes = [];

    /**
     * Свойство содержит список сохраненных динамических атрибутов модели.
     *
     * @var array
     */
    protected $oldDynamicAttributes = [];

    /**
     * Метод предварительной инициализации модели.
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        foreach ($this->dynamicAttributes() as $name => $value) {
            if (is_int($name)) {
                $this->dynamicAttributes[$value] = null;
            } else {
                $this->dynamicAttributes[$name] = $value;
            }
        }
    }

    /**
     * Метод возвращает список имен динамических атрибутов.
     *
     * @return array
     */
    abstract public function dynamicAttributes();

    /**
     * Геттер для динамисеских атрибутов.
     *
     * @param string $name Имя атрибута.
     *
     * @return mixed
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->dynamicAttributes)) {
            return $this->dynamicAttributes[$name];
        } else {
            return parent::__get($name);
        }
    }

    /**
     * Сеттер для динамисеских атрибутов.
     *
     * @param string $name  Имя атрибута.
     * @param mixed  $value Значение атрибута.
     *
     * @return void
     */
    public function __set($name, $value)
    {
        if (array_key_exists($name, $this->dynamicAttributes)) {
            $this->dynamicAttributes[$name] = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * Метод для проверки установки значения атрибута.
     *
     * @param string $name Имя атрибута.
     *
     * @return boolean
     */
    public function __isset($name)
    {
        if (array_key_exists($name, $this->dynamicAttributes)) {
            return isset($this->dynamicAttributes[$name]);
        } else {
            return parent::__isset($name);
        }
    }

    /**
     * Метод для сброса динамического атрибута.
     *
     * @param string $name Имя атрибута.
     *
     * @return void
     */
    public function __unset($name)
    {
        if (array_key_exists($name, $this->dynamicAttributes)) {
            unset($this->dynamicAttributes[$name]);
        } else {
            parent::__unset($name);
        }
    }

    /**
     * Метод для определение атрибута.
     *
     * @param string $name  Имя атрибута.
     * @param mixed  $value Значение атрибута.
     *
     * @return void
     */
    public function defineAttribute($name, $value = null)
    {
        $this->dynamicAttributes[$name] = $value;
    }

    /**
     * Метод для удаления атрибута.
     *
     * @param string $name Имя атрибута.
     *
     * @return void
     */
    public function undefineAttribute($name)
    {
        unset($this->dynamicAttributes[$name]);
    }

    /**
     * Метод возвращает список всех атрибутов.
     *
     * @return array
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), array_keys($this->dynamicAttributes));
    }

    /**
     * Метод проверяет есть ли такой динамический атрибут.
     *
     * @param string $name Имя атрибута для проверки.
     *
     * @return boolean
     */
    public function hasDynamicAttribute($name)
    {
        return array_key_exists($name, $this->dynamicAttributes);
    }

    /**
     * Метод сохраняет текущее состояние атрибутов.
     *
     * @return void
     */
    public function saveAttributesState()
    {
        $this->oldDynamicAttributes = $this->dynamicAttributes;
    }
}
