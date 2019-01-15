<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors\iterators\errors;

use ArrayIterator;
use Userstory\Yii2Errors\interfaces\errors\ErrorInterface;
use Userstory\Yii2Errors\interfaces\errors\ListIteratorInterface;

/**
 * Класс ErrorListIterator.
 * Класс итератора по коллекции.
 */
class ListIterator extends ArrayIterator implements ListIteratorInterface
{
    /**
     * Метод возвращает текущий элемент коллекции.
     * Метод необходим для обеспечения строгой типизации возвращаемого результата,
     * которой нет в родительском методе.
     *
     * @return ErrorInterface
     *
     * @todo Избавиться от переменной $result, когда починят прекомит.
     */
    public function current(): ErrorInterface
    {
        $result = parent::current();
        return $result;
    }
}
