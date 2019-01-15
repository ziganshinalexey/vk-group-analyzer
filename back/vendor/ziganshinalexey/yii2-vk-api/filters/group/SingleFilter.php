<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\filters\group;

use Ziganshinalexey\Yii2VkApi\interfaces\group\filters\SingleFilterInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\filters\SingleFilterOperationInterface;

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
        if ($this->getActivity()) {
            $operation->byActivity((string)$this->getActivity(), 'like');
        }
        if ($this->getDescription()) {
            $operation->byDescription((string)$this->getDescription(), 'like');
        }
        return $operation;
    }

    /**
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setActivity(string $value): SingleFilterInterface
    {
        $this->activity = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setDescription(string $value): SingleFilterInterface
    {
        $this->description = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "ВК группа".
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
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
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
