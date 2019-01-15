<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors\factories\errors;

use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Errors\hydrators\errors\CollectionYiiHydrator;
use Userstory\Yii2Errors\interfaces\errors\CollectionInterface;
use Userstory\Yii2Errors\interfaces\errors\ListIteratorInterface;
use Userstory\Yii2Errors\interfaces\errors\ErrorInterface;
use Userstory\Yii2Errors\interfaces\errors\FactoryInterface;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use yii\base\InvalidConfigException;

/**
 * Фабрика Factory.
 * Фабрика отвечает за породждение объектов пакета.
 */
class Factory extends ModelsFactory implements FactoryInterface
{
    public const ERROR_PROTOTYPE                         = 'errorPrototype';
    public const ERROR_COLLECTION_PROTOTYPE              = 'errorCollectionPrototype';
    public const ERROR_LIST_ITERATOR_PROTOTYPE           = 'errorListIteratorPrototype';
    public const ERROR_COLLECTION_YII_HYDRATOR_PROTOTYPE = 'errorCollectionIteratorPrototype';

    /**
     * Метод получает прототип объекта ошибки.
     *
     * @return ErrorInterface
     *
     * @throws InvalidConfigException Генерируется в случе неверной конфигурации фабрики моделей.
     */
    public function getError(): ErrorInterface
    {
        return $this->getModelInstance(static::ERROR_PROTOTYPE, [], false);
    }

    /**
     * Метод получает прототип объекта коллекции ошибок.
     *
     * @return CollectionInterface
     *
     * @throws InvalidConfigException Генерируется в случе неверной конфигурации фабрики моделей.
     */
    public function getCollection(): CollectionInterface
    {
        return $this->getModelInstance(static::ERROR_COLLECTION_PROTOTYPE, [], false);
    }

    /**
     * Метод возвращает итератор массива объектов ошибок.
     *
     * @param ErrorInterface[] $list Массив объектов ошибок.
     *
     * @return ListIteratorInterface
     */
    public function getListIterator(array $list): ListIteratorInterface
    {
        $class = $this->modelConfigList[static::ERROR_LIST_ITERATOR_PROTOTYPE][static::OBJECT_TYPE_KEY];
        return new $class($list);
    }

    /**
     * Метод возвращает гидратор коллекции ошибок из/в формат ошибок Yii.
     *
     * @return HydratorInterface
     *
     * @throws InvalidConfigException Генерируется в случе неверной конфигурации фабрики моделей.
     */
    public function getCollectionYiiHydrator(): HydratorInterface
    {
        $result = $this->getModelInstance(static::ERROR_COLLECTION_YII_HYDRATOR_PROTOTYPE);
        if (! $result instanceof CollectionYiiHydrator) {
            throw new ExtendsMismatchException(get_class($result) . ' must be instance of  ' . CollectionYiiHydrator::class);
        }
        $result->setErrorPrototype($this->getError());
        return $result;
    }
}
