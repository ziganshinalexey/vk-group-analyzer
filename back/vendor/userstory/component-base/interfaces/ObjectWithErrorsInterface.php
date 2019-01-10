<?php

namespace Userstory\ComponentBase\interfaces;

/**
 * Интерфейс ObjectWithErrorsInterface.
 * Интерфейс объекта, содержащего информацию об ошибках.
 *
 * @package Userstory\ModuleHr\interfaces
 */
interface ObjectWithErrorsInterface
{
    /**
     * Метод получает ошибки, возникшие в ходе выполнения операции.
     *
     * @param string $group Группа ошибок.
     *
     * @return array
     */
    public function getErrors($group = null);

    /**
     * Метод отвечает на вопрос, произошли ли ошибки в ходе выполнения операций.
     *
     * @param string $group Группа ошибок.
     *
     * @return boolean
     */
    public function hasErrors($group = null);

    /**
     * Метод добавляет ошибки, возникшие в ходе выполнения операции.
     *
     * @param array $items Список ошибок.
     *
     * @return mixed
     */
    public function addErrors(array $items);

    /**
     * Метод добавляет ошибку, в список ошибок объекта.
     *
     * @param string $attribute Атрибут модели, для которого добавляется ошибка.
     * @param string $error     Текст ошибки.
     *
     * @return mixed
     */
    public function addError($attribute, $error = '');
}
