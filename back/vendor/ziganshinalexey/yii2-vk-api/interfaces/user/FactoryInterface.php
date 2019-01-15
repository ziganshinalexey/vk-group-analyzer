<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user;

use Userstory\Yii2Dto\interfaces\results\DtoListResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\MultiFindOperationInterface;

/**
 * Интерфейс фабрики. Опеределяет методы порождения моделей пакета.
 */
interface FactoryInterface
{
    /**
     * Метод возвращает прототип объекта результата операции над списокм сущностей "ВК пользователь".
     *
     * @return DtoListResultInterface
     */
    public function getUserListOperationResultPrototype(): DtoListResultInterface;

    /**
     * Метод возвращает интерфейс операции для поиска нескольких сущностей "ВК пользователь".
     *
     * @return MultiFindOperationInterface
     */
    public function getUserMultiFindOperation(): MultiFindOperationInterface;

    /**
     * Метод возвращает протитип модели DTO сущности "ВК пользователь".
     *
     * @return UserInterface
     */
    public function getUserPrototype(): UserInterface;
}
