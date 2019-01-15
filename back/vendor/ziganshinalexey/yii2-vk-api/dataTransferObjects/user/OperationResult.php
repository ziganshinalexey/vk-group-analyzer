<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\dataTransferObjects\user;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\OperationResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;

/**
 * Объект отвечающий за результат работы операции.
 */
class OperationResult extends Model implements OperationResultInterface
{
    /**
     * DTO сущности, получившаяся в результате выполнения операции.
     *
     * @var UserInterface|null
     */
    protected $user;

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
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
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
     * @param UserInterface $value Новое значение.
     *
     * @return OperationResultInterface
     */
    public function setUser(UserInterface $value): OperationResultInterface
    {
        $this->user = $value;
        return $this;
    }
}
