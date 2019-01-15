<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\group\dto;

use Userstory\ComponentBase\interfaces\BaseOperationResultInterface;
use Userstory\ComponentBase\interfaces\PrototypeInterface;

/**
 * Результат работы команды, выполняющей действия над несколькими сущностями "ВК группа".
 */
interface OperationListResultInterface extends BaseOperationResultInterface, PrototypeInterface
{
    /**
     * Метод возвращает список DTO сущностей, получившихся в результате работы операции.
     *
     * @return GroupInterface[]
     */
    public function getGroupList(): array;

    /**
     * Метод устанавливает список DTO сущсностей, получившихся в результате работы команды.
     *
     * @param GroupInterface[] $value Новое значение.
     *
     * @return OperationListResultInterface
     */
    public function setGroupList(array $value): OperationListResultInterface;
}
