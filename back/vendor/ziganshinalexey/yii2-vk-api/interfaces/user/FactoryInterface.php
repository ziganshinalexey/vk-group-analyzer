<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user;

use Userstory\ComponentBase\interfaces\DTOValidatorInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\OperationListResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\OperationResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\MultiFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleUpdateOperationInterface;

/**
 * Интерфейс фабрики. Опеределяет методы порождения моделей пакета.
 */
interface FactoryInterface
{
    /**
     * Метод возвращает прототип объекта результата операции над списокм сущностей "ВК пользователь".
     *
     * @return OperationListResultInterface
     */
    public function getUserListOperationResultPrototype(): OperationListResultInterface;

    /**
     * Метод возвращает интерфейс операции для удаления нескольких сущностей "ВК пользователь".
     *
     * @return MultiDeleteOperationInterface
     */
    public function getUserMultiDeleteOperation(): MultiDeleteOperationInterface;

    /**
     * Метод возвращает интерфейс операции для поиска нескольких сущностей "ВК пользователь".
     *
     * @return MultiFindOperationInterface
     */
    public function getUserMultiFindOperation(): MultiFindOperationInterface;

    /**
     * Метод возвращает прототип объекта результата операции над сущностью "ВК пользователь".
     *
     * @return OperationResultInterface
     */
    public function getUserOperationResultPrototype(): OperationResultInterface;

    /**
     * Метод возвращает протитип модели DTO сущности "ВК пользователь".
     *
     * @return UserInterface
     */
    public function getUserPrototype(): UserInterface;

    /**
     * Метод возвращает интерфейс операции для создания одной сущности "ВК пользователь".
     *
     * @return SingleCreateOperationInterface
     */
    public function getUserSingleCreateOperation(): SingleCreateOperationInterface;

    /**
     * Метод возвращает интерфейс операции для поиска одной сущности "ВК пользователь".
     *
     * @return SingleFindOperationInterface
     */
    public function getUserSingleFindOperation(): SingleFindOperationInterface;

    /**
     * Метод возвращает интерфейс для обновления одной сущности "ВК пользователь".
     *
     * @return SingleUpdateOperationInterface
     */
    public function getUserSingleUpdateOperation(): SingleUpdateOperationInterface;

    /**
     * Метод возвращает прототип объекта валидатора сущности "ВК пользователь".
     *
     * @return DTOValidatorInterface
     */
    public function getUserValidator(): DTOValidatorInterface;
}
