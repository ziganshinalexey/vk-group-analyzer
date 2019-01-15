<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\traits;

use Userstory\Yii2Dto\interfaces\BaseDtoInterface;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use function get_class;
use function is_object;

/**
 * Трейт объекта, который работает с прототипом ДТО.
 */
trait WithDtoPrototypeTrait
{
    /**
     * Объект-прототип дто для работы.
     *
     * @var BaseDtoInterface|null
     */
    protected $dtoPrototype;

    /**
     * Метод возвращает прототип ДТО.
     * Строгой типизации нет специально для возможности наследования.
     *
     * @return BaseDtoInterface
     *
     * @throws ExtendsMismatchException Исключение генерируется если установлен неправильный объект-прототип.
     */
    public function getDtoPrototype()
    {
        if (! is_object($this->result)) {
            throw new ExtendsMismatchException('Result must be an object');
        }
        if (! $this->dtoPrototype instanceof BaseDtoInterface) {
            throw new ExtendsMismatchException(get_class($this->dtoPrototype) . ' must implement ' . BaseDtoInterface::class);
        }
        return $this->dtoPrototype;
    }

    /**
     * Метод устанавливает прототип ДТО.
     *
     * @param BaseDtoInterface $dtoPrototype Новое значение.
     *
     * @return static
     */
    public function setDtoPrototype(BaseDtoInterface $dtoPrototype)
    {
        $this->dtoPrototype = $dtoPrototype;
        return $this;
    }
}
