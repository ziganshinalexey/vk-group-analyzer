<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\components;

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\ComponentBase\traits\ComponentEventTrait;
use Userstory\ComponentBase\traits\ModelsFactoryTrait;
use yii\base\Component;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonType\interfaces\personType\ComponentInterface;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;
use Ziganshinalexey\PersonType\interfaces\personType\FactoryInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\MultiFindOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\SingleCreateOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\SingleFindOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\SingleUpdateOperationInterface;
use function get_class;

/**
 * Компонент. Является программным API для доступа к пакету.
 */
class PersonTypeComponent extends Component implements ComponentWithFactoryInterface, ComponentInterface
{
    use ModelsFactoryTrait {
        ModelsFactoryTrait::getModelFactory as getModelFactoryFromTrait;
    }
    use ComponentEventTrait;

    /**
     * Метод возвращает операцию создания одного экземпляра сущности "Тип личности".
     *
     * @param PersonTypeInterface $item Сущность для создания.
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return SingleCreateOperationInterface
     */
    public function createOne(PersonTypeInterface $item): SingleCreateOperationInterface
    {
        $operation = $this->getModelFactory()->getPersonTypeSingleCreateOperation()->setPersonType($item);
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerCreate',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает операцию удаления нескольких экземпляров сущности "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return MultiDeleteOperationInterface
     */
    public function deleteMany(): MultiDeleteOperationInterface
    {
        $operation = $this->getModelFactory()->getPersonTypeMultiDeleteOperation();
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerDelete',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает операцию поиска нескольких экземпляров сущности "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return MultiFindOperationInterface
     */
    public function findMany(): MultiFindOperationInterface
    {
        $operation = $this->getModelFactory()->getPersonTypeMultiFindOperation();
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerFind',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает операцию поиска одного экземпляра сущности "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return SingleFindOperationInterface
     */
    public function findOne(): SingleFindOperationInterface
    {
        $operation = $this->getModelFactory()->getPersonTypeSingleFindOperation();
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerFind',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает фабрику моделей пакета "Тип личности".
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
     * Метод возвращает прототип объекта DTO "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return PersonTypeInterface
     */
    public function getPersonTypePrototype(): PersonTypeInterface
    {
        return $this->getModelFactory()->getPersonTypePrototype();
    }

    /**
     * Метод возвращает интерефейс операции обновления одного экземпляра сущности "Тип личности".
     *
     * @param PersonTypeInterface $item Сущность для обновления.
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return SingleUpdateOperationInterface
     */
    public function updateOne(PersonTypeInterface $item): SingleUpdateOperationInterface
    {
        $operation = $this->getModelFactory()->getPersonTypeSingleUpdateOperation()->setPersonType($item);
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerUpdate',
        ]);
        return $operation;
    }
}
