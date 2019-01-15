<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\dataTransferObjects\user;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\OperationListResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;

/**
 * Объект результат работы операции с множеством DTO сущностей.
 */
class OperationListResult extends Model implements OperationListResultInterface
{
    /**
     * DTO, получившиеся в результате выполнения операции.
     *
     * @var UserInterface[]
     */
    protected $userList = [];

    /**
     * Метод копирования объекта результата.
     *
     * @return OperationListResultInterface
     */
    public function copy(): OperationListResultInterface
    {
        return new static();
    }

    /**
     * Метод возвращает список DTO сущностей, получившихся в результате работы операции.
     *
     * @return UserInterface[]
     */
    public function getUserList(): array
    {
        return $this->userList;
    }

    /**
     * Метод указывает прошла ли операция успешно.
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return ! $this->hasErrors();
    }

    /**
     * Метод устанавливает список DTO сущсностей, получившихся в результате работы команды.
     *
     * @param UserInterface[] $value Новое значение.
     *
     * @return OperationListResultInterface
     */
    public function setUserList(array $value): OperationListResultInterface
    {
        $this->userList = $value;
        return $this;
    }
}
