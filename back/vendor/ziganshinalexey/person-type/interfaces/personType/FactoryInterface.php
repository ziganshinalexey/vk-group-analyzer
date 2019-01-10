<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\interfaces\personType;

use Userstory\ComponentBase\interfaces\DTOValidatorInterface;
use Ziganshinalexey\PersonType\interfaces\personType\dto\OperationListResultInterface;
use Ziganshinalexey\PersonType\interfaces\personType\dto\OperationResultInterface;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\MultiFindOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\SingleCreateOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\SingleFindOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\SingleUpdateOperationInterface;

/**
 * Интерфейс фабрики. Опеределяет методы порождения моделей пакета.
 */
interface FactoryInterface
{
    /**
     * Метод возвращает прототип объекта результата операции над списокм сущностей "Тип личности".
     *
     * @return OperationListResultInterface
     */
    public function getPersonTypeListOperationResultPrototype(): OperationListResultInterface;

    /**
     * Метод возвращает интерфейс операции для удаления нескольких сущностей "Тип личности".
     *
     * @return MultiDeleteOperationInterface
     */
    public function getPersonTypeMultiDeleteOperation(): MultiDeleteOperationInterface;

    /**
     * Метод возвращает интерфейс операции для поиска нескольких сущностей "Тип личности".
     *
     * @return MultiFindOperationInterface
     */
    public function getPersonTypeMultiFindOperation(): MultiFindOperationInterface;

    /**
     * Метод возвращает прототип объекта результата операции над сущностью "Тип личности".
     *
     * @return OperationResultInterface
     */
    public function getPersonTypeOperationResultPrototype(): OperationResultInterface;

    /**
     * Метод возвращает протитип модели DTO сущности "Тип личности".
     *
     * @return PersonTypeInterface
     */
    public function getPersonTypePrototype(): PersonTypeInterface;

    /**
     * Метод возвращает интерфейс операции для создания одной сущности "Тип личности".
     *
     * @return SingleCreateOperationInterface
     */
    public function getPersonTypeSingleCreateOperation(): SingleCreateOperationInterface;

    /**
     * Метод возвращает интерфейс операции для поиска одной сущности "Тип личности".
     *
     * @return SingleFindOperationInterface
     */
    public function getPersonTypeSingleFindOperation(): SingleFindOperationInterface;

    /**
     * Метод возвращает интерфейс для обновления одной сущности "Тип личности".
     *
     * @return SingleUpdateOperationInterface
     */
    public function getPersonTypeSingleUpdateOperation(): SingleUpdateOperationInterface;

    /**
     * Метод возвращает прототип объекта валидатора сущности "Тип личности".
     *
     * @return DTOValidatorInterface
     */
    public function getPersonTypeValidator(): DTOValidatorInterface;
}
