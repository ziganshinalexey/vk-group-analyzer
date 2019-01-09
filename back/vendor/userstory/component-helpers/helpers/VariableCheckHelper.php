<?php

declare(strict_types = 1);

namespace Userstory\ComponentHelpers\helpers;

use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use Userstory\Yii2Exceptions\exceptions\types\IntMismatchException;
use Userstory\Yii2Exceptions\exceptions\types\ValueIsEmptyException;
use function get_class;
use function is_int;
use function is_object;

/**
 * Хелпер для проверки значений переменных.
 */
class VariableCheckHelper
{
    /**
     * Метод проверяет что значение не пусто.
     *
     * @param mixed $value Значение переменной.
     *
     * @throws ValueIsEmptyException Если проверка не прошла.
     *
     * @return void
     */
    public static function checkEmpty($value): void
    {
        if (empty($value)) {
            throw new ValueIsEmptyException('Value can not be empty');
        }
    }

    /**
     * Метод проверяет что значение является интом.
     *
     * @param mixed $value Значение переменной.
     *
     * @throws IntMismatchException Если проверка не прошла.
     *
     * @return void
     */
    public static function checkInt($value): void
    {
        if (! is_int($value)) {
            throw new IntMismatchException('Value must be integer');
        }
    }

    /**
     * Метод проверяет что объект наследует или имплементирует класс или интерфейс.
     *
     * @param mixed  $object    Объект для проверки.
     * @param string $className Название класса или интерфейса для проверки.
     *
     * @throws ExtendsMismatchException Если проверка не прошла.
     *
     * @return void
     */
    public static function checkInstanceOf($object, string $className): void
    {
        if (! is_object($object)) {
            throw new ExtendsMismatchException('Value must be an object');
        }
        if (! $object instanceof $className) {
            throw new ExtendsMismatchException(get_class($object) . ' must be instance of ' . $className);
        }
    }
}
