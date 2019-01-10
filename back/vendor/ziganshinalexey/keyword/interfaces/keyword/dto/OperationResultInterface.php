<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\interfaces\keyword\dto;

use Userstory\ComponentBase\interfaces\BaseOperationResultInterface;
use Userstory\ComponentBase\interfaces\PrototypeInterface;

/**
 * Результат работы операции, выполняющей действия над одной сущностью "Ключевое фраза".
 */
interface OperationResultInterface extends BaseOperationResultInterface, PrototypeInterface
{
    /**
     * Метод возвращает сущность, получившуюся в результате работы операции.
     *
     * @return KeywordInterface|null
     */
    public function getKeyword(): ?KeywordInterface;

    /**
     * Метод устанавливает сущность, получившуюся в результате работы операции.
     *
     * @param KeywordInterface $value Новое значение.
     *
     * @return OperationResultInterface
     */
    public function setKeyword(KeywordInterface $value): OperationResultInterface;
}
