<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\interfaces\keyword\dto;

use Userstory\ComponentBase\interfaces\BaseOperationResultInterface;
use Userstory\ComponentBase\interfaces\PrototypeInterface;

/**
 * Результат работы команды, выполняющей действия над несколькими сущностями "Ключевое фраза".
 */
interface OperationListResultInterface extends BaseOperationResultInterface, PrototypeInterface
{
    /**
     * Метод возвращает список DTO сущностей, получившихся в результате работы операции.
     *
     * @return KeywordInterface[]
     */
    public function getKeywordList(): array;

    /**
     * Метод устанавливает список DTO сущсностей, получившихся в результате работы команды.
     *
     * @param KeywordInterface[] $value Новое значение.
     *
     * @return OperationListResultInterface
     */
    public function setKeywordList(array $value): OperationListResultInterface;
}
