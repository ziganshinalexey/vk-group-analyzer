<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\filters\group;

use Userstory\ComponentBase\traits\FilterTrait;
use Ziganshinalexey\Yii2VkApi\interfaces\group\filters\MultiFilterInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\filters\MultiFilterOperationInterface;

/**
 * Класс реализует методы применения фильтра к операции.
 */
class MultiFilter extends BaseFilter implements MultiFilterInterface
{
    use FilterTrait;

    /**
     * Метод применяет фильтр к операции над списком сущностей.
     *
     * @param MultiFilterOperationInterface $operation Обект реализующий методы фильтров операции.
     *
     * @return MultiFilterOperationInterface
     */
    public function applyFilter(MultiFilterOperationInterface $operation): MultiFilterOperationInterface
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
        if ($this->getOffset()) {
            $operation->offset($this->getOffset());
        }
        if ($this->getLimit()) {
            $operation->limit($this->getLimit() + 1);
        }
        return $operation;
    }

    /**
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setActivity(string $value): MultiFilterInterface
    {
        $this->activity = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setDescription(string $value): MultiFilterInterface
    {
        $this->description = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "ВК группа".
     *
     * @param int $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setId(int $value): MultiFilterInterface
    {
        $this->id = $value;
        return $this;
    }

    /**
     * Метод задает лимит выводимых записей.
     *
     * @param int $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setLimit(int $value): MultiFilterInterface
    {
        $this->limit = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setName(string $value): MultiFilterInterface
    {
        $this->name = $value;
        return $this;
    }

    /**
     * Метод задает номер записи, с которой нуобходимо сделать выборку.
     *
     * @param int $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setOffset(int $value): MultiFilterInterface
    {
        $this->offset = $value;
        return $this;
    }
}
