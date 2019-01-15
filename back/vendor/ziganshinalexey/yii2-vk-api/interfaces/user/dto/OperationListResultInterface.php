<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user\dto;

use Userstory\ComponentBase\interfaces\BaseOperationResultInterface;
use Userstory\ComponentBase\interfaces\PrototypeInterface;

/**
 * Результат работы команды, выполняющей действия над несколькими сущностями "ВК пользователь".
 */
interface OperationListResultInterface extends BaseOperationResultInterface, PrototypeInterface
{
    /**
     * Метод возвращает список DTO сущностей, получившихся в результате работы операции.
     *
     * @return UserInterface[]
     */
    public function getUserList(): array;

    /**
     * Метод устанавливает список DTO сущсностей, получившихся в результате работы команды.
     *
     * @param UserInterface[] $value Новое значение.
     *
     * @return OperationListResultInterface
     */
    public function setUserList(array $value): OperationListResultInterface;
}
