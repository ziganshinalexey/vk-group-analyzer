<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\filters\keyword;

use Userstory\ComponentBase\traits\FilterTrait;
use Ziganshinalexey\Keyword\interfaces\keyword\filters\MultiFilterInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\filters\MultiFilterOperationInterface;

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
        if ($this->getText()) {
            $operation->byText((string)$this->getText(), 'like');
        }
        if ($this->getPersonTypeId()) {
            $operation->byPersonTypeId((int)$this->getPersonTypeId());
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
     * Метод устанавливает атрибут "Идентификатор" сущности "Ключевое фраза".
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

    /**
     * Метод устанавливает атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @param int $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setPersonTypeId(int $value): MultiFilterInterface
    {
        $this->personTypeId = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Название" сущности "Ключевое фраза".
     *
     * @param string $value Новое значение.
     *
     * @return MultiFilterInterface
     */
    public function setText(string $value): MultiFilterInterface
    {
        $this->text = $value;
        return $this;
    }
}
