<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\interfaces\personType;

use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\MultiFindOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\SingleCreateOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\SingleFindOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\SingleUpdateOperationInterface;

/**
 * Интерфейс компонента для работы с сущностями "Тип личности".
 */
interface ComponentInterface
{
    public const CREATE_OPERATION_EVENT = 'createEvent';
    public const UPDATE_OPERATION_EVENT = 'updateEvent';
    public const DELETE_OPERATION_EVENT = 'deleteEvent';
    public const FIND_OPERATION_EVENT   = 'findEvent';

    /**
     * Метод возвращает интерфейс операцию создания одного экземпляра сущности "Тип личности".
     *
     * @param PersonTypeInterface $item Сущность для создания.
     *
     * @return SingleCreateOperationInterface
     */
    public function createOne(PersonTypeInterface $item): SingleCreateOperationInterface;

    /**
     * Метод возвращает интерфейс операции удаления нескольких экземпляров сущности "Тип личности".
     *
     * @return MultiDeleteOperationInterface
     */
    public function deleteMany(): MultiDeleteOperationInterface;

    /**
     * Метод возвращает интерефейс операции поиска нескольких экземпляра сущности "Тип личности".
     *
     * @return MultiFindOperationInterface
     */
    public function findMany(): MultiFindOperationInterface;

    /**
     * Метод возвращает интерефейс операции поиска одного экземпляра сущности "Тип личности".
     *
     * @return SingleFindOperationInterface
     */
    public function findOne(): SingleFindOperationInterface;

    /**
     * Метод возвращает прототип объекта DTO "Тип личности".
     *
     * @return PersonTypeInterface
     */
    public function getPersonTypePrototype(): PersonTypeInterface;

    /**
     * Метод возвращает интерефейс операции обновления одного экземпляра сущности "Тип личности".
     *
     * @param PersonTypeInterface $item Сущность для обновления.
     *
     * @return SingleUpdateOperationInterface
     */
    public function updateOne(PersonTypeInterface $item): SingleUpdateOperationInterface;
}
