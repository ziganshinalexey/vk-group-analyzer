<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces\results;

use Userstory\ComponentBase\interfaces\PrototypeInterface;
use Userstory\Yii2Errors\interfaces\errors\WithErrorsInterface;

/**
 * Интерфейс для класса, представляющего результат выполнения какой либо операции.
 */
interface BaseResultInterface extends PrototypeInterface, WithErrorsInterface
{
    /**
     * Метод определяет была ли операция успешно выполнена.
     *
     * @return boolean
     */
    public function isSuccess(): bool;

    /**
     * Метод копирует текущий объект.
     *
     * @return static
     */
    public function copy();
}
