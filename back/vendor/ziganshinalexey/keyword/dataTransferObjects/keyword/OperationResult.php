<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\dataTransferObjects\keyword;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\OperationResultInterface;

/**
 * Объект отвечающий за результат работы операции.
 */
class OperationResult extends Model implements OperationResultInterface
{
    /**
     * DTO сущности, получившаяся в результате выполнения операции.
     *
     * @var KeywordInterface|null
     */
    protected $keyword;

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
     * @return KeywordInterface|null
     */
    public function getKeyword(): ?KeywordInterface
    {
        return $this->keyword;
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
     * @param KeywordInterface $value Новое значение.
     *
     * @return OperationResultInterface
     */
    public function setKeyword(KeywordInterface $value): OperationResultInterface
    {
        $this->keyword = $value;
        return $this;
    }
}
