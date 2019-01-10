<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\filters\personType;

use Ziganshinalexey\PersonType\interfaces\personType\filters\SingleFilterInterface;
use Ziganshinalexey\PersonType\interfaces\personType\filters\SingleFilterOperationInterface;

/**
 * Класс реализует методы применения фильтра к операции.
 */
class SingleFilter extends BaseFilter implements SingleFilterInterface
{
    /**
     * Метод применяет фильтр к операции над одной сущности.
     *
     * @param SingleFilterOperationInterface $operation Обект реализующий методы фильтров операции.
     *
     * @return SingleFilterOperationInterface
     */
    public function applyFilter(SingleFilterOperationInterface $operation): SingleFilterOperationInterface
    {
        if ($this->getId()) {
            $operation->byId((int)$this->getId());
        }
        if ($this->getName()) {
            $operation->byName((string)$this->getName(), 'like');
        }
        return $operation;
    }

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "Тип личности".
     *
     * @param int $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setId(int $value): SingleFilterInterface
    {
        $this->id = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Название" сущности "Тип личности".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setName(string $value): SingleFilterInterface
    {
        $this->name = $value;
        return $this;
    }
}
