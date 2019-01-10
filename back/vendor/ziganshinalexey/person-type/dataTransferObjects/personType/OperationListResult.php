<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\dataTransferObjects\personType;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\PersonType\interfaces\personType\dto\OperationListResultInterface;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;

/**
 * Объект результат работы операции с множеством DTO сущностей.
 */
class OperationListResult extends Model implements OperationListResultInterface
{
    /**
     * DTO, получившиеся в результате выполнения операции.
     *
     * @var PersonTypeInterface[]
     */
    protected $personTypeList = [];

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
     * @return PersonTypeInterface[]
     */
    public function getPersonTypeList(): array
    {
        return $this->personTypeList;
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
     * @param PersonTypeInterface[] $value Новое значение.
     *
     * @return OperationListResultInterface
     */
    public function setPersonTypeList(array $value): OperationListResultInterface
    {
        $this->personTypeList = $value;
        return $this;
    }
}
