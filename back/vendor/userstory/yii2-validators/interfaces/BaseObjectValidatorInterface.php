<?php

declare(strict_types = 1);

namespace Userstory\Yii2Validators\interfaces;

use Userstory\ComponentBase\interfaces\PrototypeInterface;
use Userstory\Yii2Errors\interfaces\errors\WithErrorsInterface;

/**
 * Базовый интерфейс валидатора объекта.
 */
interface BaseObjectValidatorInterface extends PrototypeInterface, WithErrorsInterface
{
    /**
     * Метод выполняет валидацию объекта.
     *
     * @param mixed $object      Объект фильтра для валидации.
     * @param bool  $clearErrors Необходимо ли очищать список ошибок при запуске валидации.
     *
     * @return boolean
     */
    public function validateObject($object, bool $clearErrors = true): bool;
}
