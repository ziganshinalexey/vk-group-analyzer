<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors\interfaces\errors;

use Userstory\Yii2Errors\interfaces\BaseCollectionInterface;

/**
 * Интерфейс CollectionInterface.
 * Интерфейс объекта коллекции ошибок.
 */
interface CollectionInterface extends BaseCollectionInterface
{
    /**
     * Метод возвращает итератор для итерирования по коллекции ошибок.
     *
     * @return ListIteratorInterface
     */
    public function getIterator(): ListIteratorInterface;

    /**
     * Метод добавляет ошибку в коллекцию.
     *
     * @param ErrorInterface $message Новая ошибка.
     *
     * @return CollectionInterface
     */
    public function add(ErrorInterface $message): CollectionInterface;

    /**
     * Метод добавляет ошибки переданной колеккции в текущую коллекцию.
     *
     * @param CollectionInterface $errorCollection Коллекция для объединения.
     *
     * @return CollectionInterface
     */
    public function merge(CollectionInterface $errorCollection): CollectionInterface;

    /**
     * Метод очищает коллекцию ошибок.
     *
     * @return CollectionInterface
     */
    public function clear(): CollectionInterface;
}
