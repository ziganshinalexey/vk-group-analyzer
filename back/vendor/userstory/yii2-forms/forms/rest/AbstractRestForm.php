<?php

declare( strict_types = 1 );

namespace Userstory\Yii2Forms\forms\rest;

use InvalidArgumentException;
use Userstory\ComponentBase\interfaces\DataTransferObjectInterface;
use yii\base\Model;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Forms\interfaces\rest\AbstractFormInterface;
use yii\base\InvalidConfigException;

/**
 * Абстрактной класс формы для REST форм.
 */
abstract class AbstractRestForm extends Model implements AbstractFormInterface
{
    /**
     * Свойтво содержит ДТО для работы с формой.
     *
     * @var DataTransferObjectInterface|null
     */
    protected $prototype;

    /**
     * Свойство хранит объект гидратора.
     *
     * @var HydratorInterface|null
     */
    protected $hydrator;

    /**
     * Метод задает значение гидратору.
     *
     * @param string $value Новое значение.
     *
     * @return AbstractFormInterface
     */
    public function setHydrator($value): AbstractFormInterface
    {
        $this->hydrator = $value;
        return $this;
    }

    /**
     * Метод возвращает объект гидратора.
     *
     * @throws InvalidConfigException Если гидратор сконфигурирован неверно.
     *
     * @return HydratorInterface
     */
    protected function getHydrator(): HydratorInterface
    {
        if (null === $this->hydrator) {
            throw new InvalidConfigException(__METHOD__ . '() Hydrator object can not be null');
        }
        return $this->hydrator;
    }

    /**
     * Метод задает значение ДТО для работы с формой.
     *
     * @param DataTransferObjectInterface $value Новое значение.
     *
     * @return AbstractFormInterface
     */
    public function setPrototype(DataTransferObjectInterface $value): AbstractFormInterface
    {
        $this->prototype = $value;
        return $this;
    }

    /**
     * Метод возвращает объект ДТО для работы с формой.
     *
     * @throws InvalidConfigException Если гидратор сконфигурирован неверно.
     *
     * @return mixed
     */
    abstract public function getPrototype();

    /**
     * Осуществлет основное действие формы - добавление элемента.
     *
     * @param array $params Параметры формы для выполнения её действия.
     *
     * @throws InvalidArgumentException Если http-код ответа не верный.
     * @throws InvalidConfigException   Если компонент не зарегистрирован.
     *
     * @inherit
     *
     * @return mixed
     */
    abstract public function run(array $params = []);
}
