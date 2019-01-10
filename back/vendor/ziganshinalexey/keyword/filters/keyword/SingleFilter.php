<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\filters\keyword;

use Ziganshinalexey\Keyword\interfaces\keyword\filters\SingleFilterInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\filters\SingleFilterOperationInterface;

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
        if ($this->getText()) {
            $operation->byText((string)$this->getText(), 'like');
        }
        if ($this->getPersonTypeId()) {
            $operation->byPersonTypeId((int)$this->getPersonTypeId());
        }
        return $operation;
    }

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "Ключевое фраза".
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
     * Метод устанавливает атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @param int $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setPersonTypeId(int $value): SingleFilterInterface
    {
        $this->personTypeId = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Название" сущности "Ключевое фраза".
     *
     * @param string $value Новое значение.
     *
     * @return SingleFilterInterface
     */
    public function setText(string $value): SingleFilterInterface
    {
        $this->text = $value;
        return $this;
    }
}
