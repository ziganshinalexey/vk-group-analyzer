<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\components;

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\ComponentBase\traits\ComponentEventTrait;
use Userstory\ComponentBase\traits\ModelsFactoryTrait;
use yii\base\Component;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Yii2VkApi\interfaces\user\ComponentInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\FactoryInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\MultiFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleUpdateOperationInterface;
use function get_class;

/**
 * Компонент. Является программным API для доступа к пакету.
 */
class UserComponent extends Component implements ComponentWithFactoryInterface, ComponentInterface
{
    use ModelsFactoryTrait {
        ModelsFactoryTrait::getModelFactory as getModelFactoryFromTrait;
    }
    use ComponentEventTrait;

    /**
     * Метод возвращает операцию создания одного экземпляра сущности "ВК пользователь".
     *
     * @param UserInterface $item Сущность для создания.
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return SingleCreateOperationInterface
     */
    public function createOne(UserInterface $item): SingleCreateOperationInterface
    {
        $operation = $this->getModelFactory()->getUserSingleCreateOperation()->setUser($item);
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerCreate',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает операцию удаления нескольких экземпляров сущности "ВК пользователь".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return MultiDeleteOperationInterface
     */
    public function deleteMany(): MultiDeleteOperationInterface
    {
        $operation = $this->getModelFactory()->getUserMultiDeleteOperation();
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerDelete',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает операцию поиска нескольких экземпляров сущности "ВК пользователь".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return MultiFindOperationInterface
     */
    public function findMany(): MultiFindOperationInterface
    {
        $operation = $this->getModelFactory()->getUserMultiFindOperation();
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerFind',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает операцию поиска одного экземпляра сущности "ВК пользователь".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return SingleFindOperationInterface
     */
    public function findOne(): SingleFindOperationInterface
    {
        $operation = $this->getModelFactory()->getUserSingleFindOperation();
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerFind',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает фабрику моделей пакета "ВК пользователь".
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
     * Метод возвращает прототип объекта DTO "ВК пользователь".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return UserInterface
     */
    public function getUserPrototype(): UserInterface
    {
        return $this->getModelFactory()->getUserPrototype();
    }

    /**
     * Метод возвращает интерефейс операции обновления одного экземпляра сущности "ВК пользователь".
     *
     * @param UserInterface $item Сущность для обновления.
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return SingleUpdateOperationInterface
     */
    public function updateOne(UserInterface $item): SingleUpdateOperationInterface
    {
        $operation = $this->getModelFactory()->getUserSingleUpdateOperation()->setUser($item);
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerUpdate',
        ]);
        return $operation;
    }
}
