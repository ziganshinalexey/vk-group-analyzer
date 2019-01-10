<?php

namespace Userstory\ComponentBase\interfaces;

/**
 * Интерфейс DTOValidatorInterface.
 * Интерфейс валидатора ДТО объекта.
 *
 * @deprecated Следует использовать Userstory\Yii2Validators\interfaces\BaseObjectValidatorInterface.
 */
interface DTOValidatorInterface extends ObjectWithErrorsInterface, PrototypeInterface
{
    /**
     * Метод выполняет валидацию ДТО объекта.
     * TODO: Добавить строгую типизацию public function validateObject(object $object): bool.
     *
     * @param mixed $object ДТО объект для валидации.
     *
     * @return boolean
     */
    public function validateObject($object): bool;
}
