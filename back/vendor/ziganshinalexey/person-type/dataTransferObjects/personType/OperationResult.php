<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\dataTransferObjects\personType;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\PersonType\interfaces\personType\dto\OperationResultInterface;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;

/**
 * Объект отвечающий за результат работы операции.
 */
class OperationResult extends Model implements OperationResultInterface
{
    /**
     * DTO сущности, получившаяся в результате выполнения операции.
     *
     * @var PersonTypeInterface|null
     */
    protected $personType;

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
     * @return PersonTypeInterface|null
     */
    public function getPersonType(): ?PersonTypeInterface
    {
        return $this->personType;
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
     * @param PersonTypeInterface $value Новое значение.
     *
     * @return OperationResultInterface
     */
    public function setPersonType(PersonTypeInterface $value): OperationResultInterface
    {
        $this->personType = $value;
        return $this;
    }
}
