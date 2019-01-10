<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\interfaces\personType\dto;

use Userstory\ComponentBase\interfaces\BaseOperationResultInterface;
use Userstory\ComponentBase\interfaces\PrototypeInterface;

/**
 * Результат работы команды, выполняющей действия над несколькими сущностями "Тип личности".
 */
interface OperationListResultInterface extends BaseOperationResultInterface, PrototypeInterface
{
    /**
     * Метод возвращает список DTO сущностей, получившихся в результате работы операции.
     *
     * @return PersonTypeInterface[]
     */
    public function getPersonTypeList(): array;

    /**
     * Метод устанавливает список DTO сущсностей, получившихся в результате работы команды.
     *
     * @param PersonTypeInterface[] $value Новое значение.
     *
     * @return OperationListResultInterface
     */
    public function setPersonTypeList(array $value): OperationListResultInterface;
}
