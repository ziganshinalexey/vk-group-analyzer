<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors\interfaces;

use IteratorAggregate;

/**
 * Интерфейс BaseCollectionInterface.
 * Интерфейс объекта коллекции.
 */
interface BaseCollectionInterface extends IteratorAggregate
{
    /**
     * Метод проверяет является ли коллекция пустой.
     *
     * @return bool
     */
    public function isEmpty(): bool;
}
