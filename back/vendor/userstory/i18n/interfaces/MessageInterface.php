<?php

namespace Userstory\I18n\interfaces;

use Userstory\ComponentBase\interfaces\DataModelInterface;

/**
 * Интерфейс LanguageInterface Объявляет реализацию сущности языка.
 *
 * @package Userstory\I18n\interfaces
 */
interface MessageInterface extends DataModelInterface
{
    /**
     * Метод задает идентификатор перевода.
     *
     * @param integer $value Новое значение.
     *
     * @return void
     */
    public function setId($value);

    /**
     * Метод возвращает идентификатор перевода.
     *
     * @return integer
     */
    public function getId();

    /**
     * Метод задает идентификатор языка.
     *
     * @param integer $value Новое значение.
     *
     * @return void
     */
    public function setLanguageId($value);

    /**
     * Метод возвращает идентификатор языка.
     *
     * @return integer
     */
    public function getLanguageId();

    /**
     * Метод задает текст перевода.
     *
     * @param integer $value Новое значение.
     *
     * @return void
     */
    public function setTranslation($value);

    /**
     * Метод возвращает текст перевода.
     *
     * @return integer
     */
    public function getTranslation();

    /**
     * Метод задает флаг новой записи.
     *
     * @param integer $value Новое значение.
     *
     * @return void
     */
    public function setIsNewRecord($value);

    /**
     * Метод возвращает флаг новой записи.
     *
     * @return integer
     */
    public function getIsNewRecord();

    /**
     * Метод возвращает язык записи.
     *
     * @return LanguageInterface
     */
    public function getLanguage();
}
