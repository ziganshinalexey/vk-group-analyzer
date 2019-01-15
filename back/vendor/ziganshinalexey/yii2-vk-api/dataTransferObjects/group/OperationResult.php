<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\dataTransferObjects\group;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\OperationResultInterface;

/**
 * Объект отвечающий за результат работы операции.
 */
class OperationResult extends Model implements OperationResultInterface
{
    /**
     * DTO сущности, получившаяся в результате выполнения операции.
     *
     * @var GroupInterface|null
     */
    protected $group;

    /**
     * Метод копирования объекта результата.
     *
     * @return OperationResultInterface
     */
    public function copy(): OperationResultInterface
    {
        return new static();
    }

    /**
     * Метод возвращает сущность, получившуюся в результате работы операции.
     *
     * @return GroupInterface|null
     */
    public function getGroup(): ?GroupInterface
    {
        return $this->group;
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
     * Метод устанавливает сущность, получившуюся в результате работы операции.
     *
     * @param GroupInterface $value Новое значение.
     *
     * @return OperationResultInterface
     */
    public function setGroup(GroupInterface $value): OperationResultInterface
    {
        $this->group = $value;
        return $this;
    }
}
