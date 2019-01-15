<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\components;

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\ComponentBase\traits\ComponentEventTrait;
use Userstory\ComponentBase\traits\ModelsFactoryTrait;
use yii\base\Component;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Yii2VkApi\interfaces\group\ComponentInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\FactoryInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\MultiFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\SingleFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\SingleUpdateOperationInterface;
use function get_class;

/**
 * Компонент. Является программным API для доступа к пакету.
 */
class GroupComponent extends Component implements ComponentWithFactoryInterface, ComponentInterface
{
    use ModelsFactoryTrait {
        ModelsFactoryTrait::getModelFactory as getModelFactoryFromTrait;
    }
    use ComponentEventTrait;

    /**
     * Метод возвращает операцию создания одного экземпляра сущности "ВК группа".
     *
     * @param GroupInterface $item Сущность для создания.
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return SingleCreateOperationInterface
     */
    public function createOne(GroupInterface $item): SingleCreateOperationInterface
    {
        $operation = $this->getModelFactory()->getGroupSingleCreateOperation()->setGroup($item);
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerCreate',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает операцию удаления нескольких экземпляров сущности "ВК группа".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return MultiDeleteOperationInterface
     */
    public function deleteMany(): MultiDeleteOperationInterface
    {
        $operation = $this->getModelFactory()->getGroupMultiDeleteOperation();
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerDelete',
        ]);
        return $operation;
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
        $operation = $this->getModelFactory()->getGroupMultiFindOperation();
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerFind',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает операцию поиска одного экземпляра сущности "ВК группа".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return SingleFindOperationInterface
     */
    public function findOne(): SingleFindOperationInterface
    {
        $operation = $this->getModelFactory()->getGroupSingleFindOperation();
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerFind',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает прототип объекта DTO "ВК группа".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return GroupInterface
     */
    public function getGroupPrototype(): GroupInterface
    {
        return $this->getModelFactory()->getGroupPrototype();
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
        $modelFactory = $this->getModelFactoryFromTrait();
        if (! $modelFactory instanceof FactoryInterface) {
            throw new InvalidConfigException('Class ' . get_class($modelFactory) . ' must implement interface ' . FactoryInterface::class);
        }
        return $modelFactory;
    }

    /**
     * Метод возвращает интерефейс операции обновления одного экземпляра сущности "ВК группа".
     *
     * @param GroupInterface $item Сущность для обновления.
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return SingleUpdateOperationInterface
     */
    public function updateOne(GroupInterface $item): SingleUpdateOperationInterface
    {
        $operation = $this->getModelFactory()->getGroupSingleUpdateOperation()->setGroup($item);
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerUpdate',
        ]);
        return $operation;
    }
}
