<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user;

use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\MultiFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleUpdateOperationInterface;

/**
 * Интерфейс компонента для работы с сущностями "ВК пользователь".
 */
interface ComponentInterface
{
    public const CREATE_OPERATION_EVENT = 'createEvent';
    public const UPDATE_OPERATION_EVENT = 'updateEvent';
    public const DELETE_OPERATION_EVENT = 'deleteEvent';
    public const FIND_OPERATION_EVENT   = 'findEvent';

    /**
     * Метод возвращает интерфейс операцию создания одного экземпляра сущности "ВК пользователь".
     *
     * @param UserInterface $item Сущность для создания.
     *
     * @return SingleCreateOperationInterface
     */
    public function createOne(UserInterface $item): SingleCreateOperationInterface;

    /**
     * Метод возвращает интерфейс операции удаления нескольких экземпляров сущности "ВК пользователь".
     *
     * @return MultiDeleteOperationInterface
     */
    public function deleteMany(): MultiDeleteOperationInterface;

    /**
     * Метод возвращает интерефейс операции поиска нескольких экземпляра сущности "ВК пользователь".
     *
     * @return MultiFindOperationInterface
     */
    public function findMany(): MultiFindOperationInterface;

    /**
     * Метод возвращает интерефейс операции поиска одного экземпляра сущности "ВК пользователь".
     *
     * @return SingleFindOperationInterface
     */
    public function findOne(): SingleFindOperationInterface;

    /**
     * Метод возвращает прототип объекта DTO "ВК пользователь".
     *
     * @return UserInterface
     */
    public function getUserPrototype(): UserInterface;

    /**
     * Метод возвращает интерефейс операции обновления одного экземпляра сущности "ВК пользователь".
     *
     * @param UserInterface $item Сущность для обновления.
     *
     * @return SingleUpdateOperationInterface
     */
    public function updateOne(UserInterface $item): SingleUpdateOperationInterface;
}
