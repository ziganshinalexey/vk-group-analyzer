<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\interfaces\keyword;

use Userstory\ComponentBase\interfaces\DTOValidatorInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\OperationListResultInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\OperationResultInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\MultiFindOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleFindOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleUpdateOperationInterface;

/**
 * Интерфейс фабрики. Опеределяет методы порождения моделей пакета.
 */
interface FactoryInterface
{
    /**
     * Метод возвращает прототип объекта результата операции над списокм сущностей "Ключевое фраза".
     *
     * @return OperationListResultInterface
     */
    public function getKeywordListOperationResultPrototype(): OperationListResultInterface;

    /**
     * Метод возвращает интерфейс операции для удаления нескольких сущностей "Ключевое фраза".
     *
     * @return MultiDeleteOperationInterface
     */
    public function getKeywordMultiDeleteOperation(): MultiDeleteOperationInterface;

    /**
     * Метод возвращает интерфейс операции для поиска нескольких сущностей "Ключевое фраза".
     *
     * @return MultiFindOperationInterface
     */
    public function getKeywordMultiFindOperation(): MultiFindOperationInterface;

    /**
     * Метод возвращает прототип объекта результата операции над сущностью "Ключевое фраза".
     *
     * @return OperationResultInterface
     */
    public function getKeywordOperationResultPrototype(): OperationResultInterface;

    /**
     * Метод возвращает протитип модели DTO сущности "Ключевое фраза".
     *
     * @return KeywordInterface
     */
    public function getKeywordPrototype(): KeywordInterface;

    /**
     * Метод возвращает интерфейс операции для создания одной сущности "Ключевое фраза".
     *
     * @return SingleCreateOperationInterface
     */
    public function getKeywordSingleCreateOperation(): SingleCreateOperationInterface;

    /**
     * Метод возвращает интерфейс операции для поиска одной сущности "Ключевое фраза".
     *
     * @return SingleFindOperationInterface
     */
    public function getKeywordSingleFindOperation(): SingleFindOperationInterface;

    /**
     * Метод возвращает интерфейс для обновления одной сущности "Ключевое фраза".
     *
     * @return SingleUpdateOperationInterface
     */
    public function getKeywordSingleUpdateOperation(): SingleUpdateOperationInterface;

    /**
     * Метод возвращает прототип объекта валидатора сущности "Ключевое фраза".
     *
     * @return DTOValidatorInterface
     */
    public function getKeywordValidator(): DTOValidatorInterface;
}
