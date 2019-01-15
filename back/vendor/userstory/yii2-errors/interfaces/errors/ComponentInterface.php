<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors\interfaces\errors;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;

/**
 * Интерфейс ComponentInterface.
 * Интерфейс компонента подсистемы ошибок.
 *
 * @package Userstory\Yii2Errors\interfaces\errors
 */
interface ComponentInterface
{
    public const COMPONENT_KEY = 'errors';

    /**
     * Метод возаращает прототип объекта ошибки.
     *
     * @return ErrorInterface
     */
    public function getError(): ErrorInterface;

    /**
     * Метод возвращает прототип коллекции ошибок.
     *
     * @return CollectionInterface
     */
    public function getCollection(): CollectionInterface;

    /**
     * Метод возвращает итератор массива объектов ошибок.
     *
     * @param ErrorInterface[] $list Массив объектов ошибок.
     *
     * @return ListIteratorInterface
     */
    public function getListIterator(array $list): ListIteratorInterface;

    /**
     * Метод возвращает гидратор коллекции ошибок из/в формат ошибок Yii.
     *
     * @return HydratorInterface
     */
    public function getCollectionYiiHydrator(): HydratorInterface;
}
