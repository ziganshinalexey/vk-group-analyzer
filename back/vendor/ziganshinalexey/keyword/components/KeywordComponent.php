<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\components;

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\ComponentBase\traits\ComponentEventTrait;
use Userstory\ComponentBase\traits\ModelsFactoryTrait;
use yii\base\Component;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\interfaces\keyword\ComponentInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\FactoryInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\MultiFindOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleFindOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleUpdateOperationInterface;
use function get_class;

/**
 * Компонент. Является программным API для доступа к пакету.
 */
class KeywordComponent extends Component implements ComponentWithFactoryInterface, ComponentInterface
{
    use ModelsFactoryTrait {
        ModelsFactoryTrait::getModelFactory as getModelFactoryFromTrait;
    }
    use ComponentEventTrait;

    /**
     * Метод возвращает операцию создания одного экземпляра сущности "Ключевое фраза".
     *
     * @param KeywordInterface $item Сущность для создания.
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return SingleCreateOperationInterface
     */
    public function createOne(KeywordInterface $item): SingleCreateOperationInterface
    {
        $operation = $this->getModelFactory()->getKeywordSingleCreateOperation()->setKeyword($item);
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerCreate',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает операцию удаления нескольких экземпляров сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return MultiDeleteOperationInterface
     */
    public function deleteMany(): MultiDeleteOperationInterface
    {
        $operation = $this->getModelFactory()->getKeywordMultiDeleteOperation();
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerDelete',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает операцию поиска нескольких экземпляров сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return MultiFindOperationInterface
     */
    public function findMany(): MultiFindOperationInterface
    {
        $operation = $this->getModelFactory()->getKeywordMultiFindOperation();
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerFind',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает операцию поиска одного экземпляра сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return SingleFindOperationInterface
     */
    public function findOne(): SingleFindOperationInterface
    {
        $operation = $this->getModelFactory()->getKeywordSingleFindOperation();
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerFind',
        ]);
        return $operation;
    }

    /**
     * Метод возвращает прототип объекта DTO "Ключевое фраза".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return KeywordInterface
     */
    public function getKeywordPrototype(): KeywordInterface
    {
        return $this->getModelFactory()->getKeywordPrototype();
    }

    /**
     * Метод возвращает фабрику моделей пакета "Ключевое фраза".
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
     * Метод возвращает интерефейс операции обновления одного экземпляра сущности "Ключевое фраза".
     *
     * @param KeywordInterface $item Сущность для обновления.
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return SingleUpdateOperationInterface
     */
    public function updateOne(KeywordInterface $item): SingleUpdateOperationInterface
    {
        $operation = $this->getModelFactory()->getKeywordSingleUpdateOperation()->setKeyword($item);
        $operation->on($operation::DO_EVENT, [
            $this,
            'triggerUpdate',
        ]);
        return $operation;
    }
}
