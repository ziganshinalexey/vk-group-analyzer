<?php

namespace Userstory\I18n\interfaces;

/**
 * Интерфейс LanguageInterface Объявляет реализацию сущности языка.
 *
 * @package Userstory\I18n\interfaces
 */
interface SourceMessageInterface
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
     * Метод задает категорию переводов.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setCategory($value);

    /**
     * Метод возвращает категорию переводов.
     *
     * @return string
     */
    public function getCategory();

    /**
     * Метод задает алиас переводов.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setMessage($value);

    /**
     * Метод возвращает алиас переводов.
     *
     * @return string
     */
    public function getMessage();

    /**
     * Метод задает комментарий к переводам.
     *
     * @param string $value Новое значение.
     *
     * @return void
     */
    public function setComment($value);

    /**
     * Метод возвращает комментарий к переводам.
     *
     * @return string
     */
    public function getComment();

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
}
