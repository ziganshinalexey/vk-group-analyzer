<?php

declare(strict_types = 1);

namespace Userstory\Yii2Errors\components\errors;

use Userstory\ComponentBase\traits\ModelsFactoryTrait;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Errors\interfaces\errors\CollectionInterface;
use Userstory\Yii2Errors\interfaces\errors\ListIteratorInterface;
use Userstory\Yii2Errors\interfaces\errors\ComponentInterface;
use Userstory\Yii2Errors\interfaces\errors\ErrorInterface;
use Userstory\Yii2Errors\interfaces\errors\FactoryInterface;
use yii\base\Component as Yii2Component;
use yii\base\InvalidConfigException;

/**
 * Класс Component.
 * Компонент подсистемы ошибок.
 *
 * @package Userstory\Yii2Errors\components\errors
 */
class Component extends Yii2Component implements ComponentInterface
{
    use ModelsFactoryTrait {
        ModelsFactoryTrait::getModelFactory as getModelFactoryFromTrait;
    }

    /**
     * Метод возвращает фабрику моделей.
     *
     * @return FactoryInterface
     *
     * @throws InvalidConfigException Генерируется в случе неверной конфигурации фабрики моделей.
     */
    protected function getModelFactory(): FactoryInterface
    {
        return $this->getModelFactoryFromTrait();
    }

    /**
     * Метод возаращает прототип объекта ошибки.
     *
     * @return ErrorInterface
     *
     * @throws InvalidConfigException Генерируется в случе неверной конфигурации фабрики моделей.
     */
    public function getError(): ErrorInterface
    {
        return $this->getModelFactory()->getError();
    }

    /**
     * Метод возвращает прототип коллекции ошибок.
     *
     * @return CollectionInterface
     *
     * @throws InvalidConfigException Генерируется в случе неверной конфигурации фабрики моделей.
     */
    public function getCollection(): CollectionInterface
    {
        return $this->getModelFactory()->getCollection();
    }

    /**
     * Метод возвращает итератор массива объектов ошибок.
     *
     * @param ErrorInterface[] $list Массив объектов ошибок.
     *
     * @return ListIteratorInterface
     *
     * @throws InvalidConfigException Генерируется в случе неверной конфигурации фабрики моделей.
     */
    public function getListIterator(array $list): ListIteratorInterface
    {
        return $this->getModelFactory()->getListIterator($list);
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
        return $this->getModelFactory()->getCollectionYiiHydrator();
    }
}
