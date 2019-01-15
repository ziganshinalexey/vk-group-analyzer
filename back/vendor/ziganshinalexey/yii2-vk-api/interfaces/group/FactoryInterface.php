<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\group;

use Userstory\ComponentBase\interfaces\DTOValidatorInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\OperationListResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\OperationResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\MultiFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\SingleFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\SingleUpdateOperationInterface;

/**
 * Интерфейс фабрики. Опеределяет методы порождения моделей пакета.
 */
interface FactoryInterface
{
    /**
     * Метод возвращает прототип объекта результата операции над списокм сущностей "ВК группа".
     *
     * @return OperationListResultInterface
     */
    public function getGroupListOperationResultPrototype(): OperationListResultInterface;

    /**
     * Метод возвращает интерфейс операции для удаления нескольких сущностей "ВК группа".
     *
     * @return MultiDeleteOperationInterface
     */
    public function getGroupMultiDeleteOperation(): MultiDeleteOperationInterface;

    /**
     * Метод возвращает интерфейс операции для поиска нескольких сущностей "ВК группа".
     *
     * @return MultiFindOperationInterface
     */
    public function getGroupMultiFindOperation(): MultiFindOperationInterface;

    /**
     * Метод возвращает прототип объекта результата операции над сущностью "ВК группа".
     *
     * @return OperationResultInterface
     */
    public function getGroupOperationResultPrototype(): OperationResultInterface;

    /**
     * Метод возвращает протитип модели DTO сущности "ВК группа".
     *
     * @return GroupInterface
     */
    public function getGroupPrototype(): GroupInterface;

    /**
     * Метод возвращает интерфейс операции для создания одной сущности "ВК группа".
     *
     * @return SingleCreateOperationInterface
     */
    public function getGroupSingleCreateOperation(): SingleCreateOperationInterface;

    /**
     * Метод возвращает интерфейс операции для поиска одной сущности "ВК группа".
     *
     * @return SingleFindOperationInterface
     */
    public function getGroupSingleFindOperation(): SingleFindOperationInterface;

    /**
     * Метод возвращает интерфейс для обновления одной сущности "ВК группа".
     *
     * @return SingleUpdateOperationInterface
     */
    public function getGroupSingleUpdateOperation(): SingleUpdateOperationInterface;

    /**
     * Метод возвращает прототип объекта валидатора сущности "ВК группа".
     *
     * @return DTOValidatorInterface
     */
    public function getGroupValidator(): DTOValidatorInterface;
}
