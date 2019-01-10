<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\dataTransferObjects\keyword;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\OperationListResultInterface;

/**
 * Объект результат работы операции с множеством DTO сущностей.
 */
class OperationListResult extends Model implements OperationListResultInterface
{
    /**
     * DTO, получившиеся в результате выполнения операции.
     *
     * @var KeywordInterface[]
     */
    protected $keywordList = [];

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
     * @return KeywordInterface[]
     */
    public function getKeywordList(): array
    {
        return $this->keywordList;
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
     * @param KeywordInterface[] $value Новое значение.
     *
     * @return OperationListResultInterface
     */
    public function setKeywordList(array $value): OperationListResultInterface
    {
        $this->keywordList = $value;
        return $this;
    }
}
