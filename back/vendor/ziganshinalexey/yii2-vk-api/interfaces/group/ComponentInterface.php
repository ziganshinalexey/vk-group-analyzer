<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\group;

use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\MultiFindOperationInterface;

/**
 * Интерфейс компонента для работы с сущностями "ВК группа".
 */
interface ComponentInterface
{
    /**
     * Метод возвращает интерефейс операции поиска нескольких экземпляра сущности "ВК группа".
     *
     * @return MultiFindOperationInterface
     */
    public function findMany(): MultiFindOperationInterface;
}
