<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\group;

use Userstory\Yii2Dto\interfaces\results\DtoListResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\MultiFindOperationInterface;

/**
 * Интерфейс фабрики. Опеределяет методы порождения моделей пакета.
 */
interface FactoryInterface
{
    /**
     * Метод возвращает прототип объекта результата операции над списокм сущностей "ВК группа".
     *
     * @return DtoListResultInterface
     */
    public function getGroupListOperationResultPrototype(): DtoListResultInterface;

    /**
     * Метод возвращает интерфейс операции для поиска нескольких сущностей "ВК группа".
     *
     * @return MultiFindOperationInterface
     */
    public function getGroupMultiFindOperation(): MultiFindOperationInterface;

    /**
     * Метод возвращает протитип модели DTO сущности "ВК группа".
     *
     * @return GroupInterface
     */
    public function getGroupPrototype(): GroupInterface;
}
