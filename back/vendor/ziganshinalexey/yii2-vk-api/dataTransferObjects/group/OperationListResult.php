<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\dataTransferObjects\group;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\OperationListResultInterface;

/**
 * Объект результат работы операции с множеством DTO сущностей.
 */
class OperationListResult extends Model implements OperationListResultInterface
{
    /**
     * DTO, получившиеся в результате выполнения операции.
     *
     * @var GroupInterface[]
     */
    protected $groupList = [];

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
     * @return GroupInterface[]
     */
    public function getGroupList(): array
    {
        return $this->groupList;
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
     * @param GroupInterface[] $value Новое значение.
     *
     * @return OperationListResultInterface
     */
    public function setGroupList(array $value): OperationListResultInterface
    {
        $this->groupList = $value;
        return $this;
    }
}
