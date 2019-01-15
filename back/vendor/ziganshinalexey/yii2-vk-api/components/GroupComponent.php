<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\components;

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\ComponentBase\traits\ModelsFactoryTrait;
use yii\base\Component;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Yii2VkApi\interfaces\group\ComponentInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\FactoryInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\MultiFindOperationInterface;

/**
 * Компонент. Является программным API для доступа к пакету.
 */
class GroupComponent extends Component implements ComponentWithFactoryInterface, ComponentInterface
{
    use ModelsFactoryTrait {
        ModelsFactoryTrait::getModelFactory as protected getModelFactoryFromTrait;
    }

    /**
     * Метод возвращает операцию поиска нескольких экземпляров сущности "ВК группа".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return MultiFindOperationInterface
     */
    public function findMany(): MultiFindOperationInterface
    {
        return $this->getModelFactory()->getGroupMultiFindOperation();
    }

    /**
     * Метод возвращает фабрику моделей пакета "ВК группа".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return FactoryInterface
     */
    public function getModelFactory(): FactoryInterface
    {
        /* @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->getModelFactoryFromTrait();
    }
}
