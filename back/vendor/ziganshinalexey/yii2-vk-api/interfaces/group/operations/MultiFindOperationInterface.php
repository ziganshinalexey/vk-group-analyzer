<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\group\operations;

use Userstory\ComponentHydrator\interfaces\ObjectWithDtoHydratorInterface;
use Userstory\Yii2Dto\interfaces\results\DtoListResultInterface;
use Userstory\Yii2Dto\interfaces\WithDtoInterface;
use Userstory\Yii2Dto\interfaces\WithDtoListResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\WithHttpClientInterface;

/**
 * Интерфейс операции, реализующей логику поиска сущности.
 */
interface MultiFindOperationInterface extends WithDtoInterface, WithDtoListResultInterface, ObjectWithDtoHydratorInterface, WithHttpClientInterface
{
    /**
     * Метод задает идентификатор пользователя.
     *
     * @param int $value
     *
     * @return MultiFindOperationInterface
     */
    public function setUserId(int $value): MultiFindOperationInterface;

    /**
     * Метод возвращает все сущности по заданному фильтру.
     *
     * @return DtoListResultInterface
     */
    public function doOperation(): DtoListResultInterface;
}
