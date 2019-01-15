<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\group\dto;

use Userstory\ComponentBase\interfaces\BaseOperationResultInterface;
use Userstory\ComponentBase\interfaces\PrototypeInterface;

/**
 * Результат работы операции, выполняющей действия над одной сущностью "ВК группа".
 */
interface OperationResultInterface extends BaseOperationResultInterface, PrototypeInterface
{
    /**
     * Метод возвращает сущность, получившуюся в результате работы операции.
     *
     * @return GroupInterface|null
     */
    public function getGroup(): ?GroupInterface;

    /**
     * Метод устанавливает сущность, получившуюся в результате работы операции.
     *
     * @param GroupInterface $value Новое значение.
     *
     * @return OperationResultInterface
     */
    public function setGroup(GroupInterface $value): OperationResultInterface;
}
