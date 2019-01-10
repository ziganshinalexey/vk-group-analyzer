<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\interfaces\personType\dto;

use Userstory\ComponentBase\interfaces\BaseOperationResultInterface;
use Userstory\ComponentBase\interfaces\PrototypeInterface;

/**
 * Результат работы операции, выполняющей действия над одной сущностью "Тип личности".
 */
interface OperationResultInterface extends BaseOperationResultInterface, PrototypeInterface
{
    /**
     * Метод возвращает сущность, получившуюся в результате работы операции.
     *
     * @return PersonTypeInterface|null
     */
    public function getPersonType(): ?PersonTypeInterface;

    /**
     * Метод устанавливает сущность, получившуюся в результате работы операции.
     *
     * @param PersonTypeInterface $value Новое значение.
     *
     * @return OperationResultInterface
     */
    public function setPersonType(PersonTypeInterface $value): OperationResultInterface;
}
