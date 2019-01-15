<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user\operations;

use Userstory\ComponentHydrator\interfaces\ObjectWithDtoHydratorInterface;
use Userstory\Yii2Dto\interfaces\results\DtoListResultInterface;
use Userstory\Yii2Dto\interfaces\WithDtoInterface;
use Userstory\Yii2Dto\interfaces\WithDtoListResultInterface;

/**
 * Интерфейс операции, реализующей логику поиска сущности.
 */
interface MultiFindOperationInterface extends WithDtoInterface, WithDtoListResultInterface, ObjectWithDtoHydratorInterface
{
    /**
     * Метод задает идентификатор пользователя.
     *
     * @param string $value
     *
     * @return MultiFindOperationInterface
     */
    public function setUserScreenName(string $value): MultiFindOperationInterface;

    /**
     * Метод возвращает все сущности по заданному фильтру.
     *
     * @return DtoListResultInterface
     */
    public function doOperation(): DtoListResultInterface;
}
