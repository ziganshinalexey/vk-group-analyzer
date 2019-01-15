<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\group;

use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\MultiFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\SingleFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\SingleUpdateOperationInterface;

/**
 * Интерфейс компонента для работы с сущностями "ВК группа".
 */
interface ComponentInterface
{
    public const CREATE_OPERATION_EVENT = 'createEvent';
    public const UPDATE_OPERATION_EVENT = 'updateEvent';
    public const DELETE_OPERATION_EVENT = 'deleteEvent';
    public const FIND_OPERATION_EVENT   = 'findEvent';

    /**
     * Метод возвращает интерфейс операцию создания одного экземпляра сущности "ВК группа".
     *
     * @param GroupInterface $item Сущность для создания.
     *
     * @return SingleCreateOperationInterface
     */
    public function createOne(GroupInterface $item): SingleCreateOperationInterface;

    /**
     * Метод возвращает интерфейс операции удаления нескольких экземпляров сущности "ВК группа".
     *
     * @return MultiDeleteOperationInterface
     */
    public function deleteMany(): MultiDeleteOperationInterface;

    /**
     * Метод возвращает интерефейс операции поиска нескольких экземпляра сущности "ВК группа".
     *
     * @return MultiFindOperationInterface
     */
    public function findMany(): MultiFindOperationInterface;

    /**
     * Метод возвращает интерефейс операции поиска одного экземпляра сущности "ВК группа".
     *
     * @return SingleFindOperationInterface
     */
    public function findOne(): SingleFindOperationInterface;

    /**
     * Метод возвращает прототип объекта DTO "ВК группа".
     *
     * @return GroupInterface
     */
    public function getGroupPrototype(): GroupInterface;

    /**
     * Метод возвращает интерефейс операции обновления одного экземпляра сущности "ВК группа".
     *
     * @param GroupInterface $item Сущность для обновления.
     *
     * @return SingleUpdateOperationInterface
     */
    public function updateOne(GroupInterface $item): SingleUpdateOperationInterface;
}
