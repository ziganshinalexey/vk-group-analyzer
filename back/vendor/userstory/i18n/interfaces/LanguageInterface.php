<?php

namespace Userstory\I18n\interfaces;

use Userstory\ComponentBase\interfaces\DataModelInterface;

/**
 * Интерфейс LanguageInterface Объявляет реализацию сущности языка.
 *
 * @package Userstory\I18n\interfaces
 */
interface LanguageInterface extends DataModelInterface
{
    /**
     * Метод задает идентификатор языка.
     *
     * @param integer $value Новое значение.
     *
     * @return void
     */
    public function setId($value);

    /**
     * Метод возвращает идентификатор языка.
     *
     * @return integer
     */
    public function getId();

    /**
     * Метод задает название кода языка.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setCode($value);

    /**
     * Метод возвращает код языка.
     *
     * @return string
     */
    public function getCode();

    /**
     * Метод задает название языка.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setName($value);

    /**
     * Метод возвращает название языка.
     *
     * @return string
     */
    public function getName();

    /**
     * Метод задает флаг языка по-умолчанию.
     *
     * @param boolean $value Новое значение.
     *
     * @return void
     */
    public function setIsDefault($value);

    /**
     * Метод возвращает флаг языка по-умолчанию.
     *
     * @return boolean
     */
    public function getIsDefault();

    /**
     * Метод задает флаг активности языка.
     *
     * @param boolean $value Новое значение.
     *
     * @return void
     */
    public function setIsActive($value);

    /**
     * Метод возвращает флаг активности языка.
     *
     * @return boolean
     */
    public function getIsActive();

    /**
     * Метод задает название урла языка.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setUrl($value);

    /**
     * Метод возвращает урл языка.
     *
     * @return string
     */
    public function getUrl();

    /**
     * Метод задает название изображения языка.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setIcon($value);

    /**
     * Метод возвращает название изображения языка.
     *
     * @return string
     */
    public function getIcon();

    /**
     * Метод задает локаль языка.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setLocale($value);

    /**
     * Метод возвращает локаль языка.
     *
     * @return string
     */
    public function getLocale();

    /**
     * Метод задает флаг новой записи.
     *
     * @param boolean $value Новое значение.
     *
     * @return void
     */
    public function setIsNewRecord($value);

    /**
     * Метод возвращает флаг новой записи.
     *
     * @return boolean
     */
    public function getIsNewRecord();
}
