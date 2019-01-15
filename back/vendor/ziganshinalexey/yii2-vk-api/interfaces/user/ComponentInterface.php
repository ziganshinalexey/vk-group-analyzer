<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user;

use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\MultiFindOperationInterface;

/**
 * Интерфейс компонента для работы с сущностями "ВК пользователь".
 */
interface ComponentInterface
{

    /**
     * Метод возвращает интерефейс операции поиска нескольких экземпляра сущности "ВК пользователь".
     *
     * @return MultiFindOperationInterface
     */
    public function findMany(): MultiFindOperationInterface;
}
