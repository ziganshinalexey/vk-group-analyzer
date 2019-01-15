<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user\dto;

use Userstory\ComponentBase\interfaces\BaseOperationResultInterface;
use Userstory\ComponentBase\interfaces\PrototypeInterface;

/**
 * Результат работы операции, выполняющей действия над одной сущностью "ВК пользователь".
 */
interface OperationResultInterface extends BaseOperationResultInterface, PrototypeInterface
{
    /**
     * Метод возвращает сущность, получившуюся в результате работы операции.
     *
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface;

    /**
     * Метод устанавливает сущность, получившуюся в результате работы операции.
     *
     * @param UserInterface $value Новое значение.
     *
     * @return OperationResultInterface
     */
    public function setUser(UserInterface $value): OperationResultInterface;
}
