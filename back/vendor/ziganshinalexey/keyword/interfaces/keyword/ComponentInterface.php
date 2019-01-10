<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\interfaces\keyword;

use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\MultiFindOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleFindOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleUpdateOperationInterface;

/**
 * Интерфейс компонента для работы с сущностями "Ключевое фраза".
 */
interface ComponentInterface
{
    public const CREATE_OPERATION_EVENT = 'createEvent';
    public const UPDATE_OPERATION_EVENT = 'updateEvent';
    public const DELETE_OPERATION_EVENT = 'deleteEvent';
    public const FIND_OPERATION_EVENT   = 'findEvent';

    /**
     * Метод возвращает интерфейс операцию создания одного экземпляра сущности "Ключевое фраза".
     *
     * @param KeywordInterface $item Сущность для создания.
     *
     * @return SingleCreateOperationInterface
     */
    public function createOne(KeywordInterface $item): SingleCreateOperationInterface;

    /**
     * Метод возвращает интерфейс операции удаления нескольких экземпляров сущности "Ключевое фраза".
     *
     * @return MultiDeleteOperationInterface
     */
    public function deleteMany(): MultiDeleteOperationInterface;

    /**
     * Метод возвращает интерефейс операции поиска нескольких экземпляра сущности "Ключевое фраза".
     *
     * @return MultiFindOperationInterface
     */
    public function findMany(): MultiFindOperationInterface;

    /**
     * Метод возвращает интерефейс операции поиска одного экземпляра сущности "Ключевое фраза".
     *
     * @return SingleFindOperationInterface
     */
    public function findOne(): SingleFindOperationInterface;

    /**
     * Метод возвращает прототип объекта DTO "Ключевое фраза".
     *
     * @return KeywordInterface
     */
    public function getKeywordPrototype(): KeywordInterface;

    /**
     * Метод возвращает интерефейс операции обновления одного экземпляра сущности "Ключевое фраза".
     *
     * @param KeywordInterface $item Сущность для обновления.
     *
     * @return SingleUpdateOperationInterface
     */
    public function updateOne(KeywordInterface $item): SingleUpdateOperationInterface;
}
