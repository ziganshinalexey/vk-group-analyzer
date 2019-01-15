<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\traits;

use Userstory\Yii2Dto\interfaces\results\DtoListResultInterface;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use function get_class;
use function is_object;

/**
 * Трейт объекта, работающего через результат со списком ДТО.
 */
trait WithDtoListResultTrait
{
    /**
     * Объект класса-результата для работы.
     *
     * @var DtoListResultInterface|null
     */
    protected $result;

    /**
     * Метод возвращает объекта результат.
     * Строгой типизации нет специально для возможности наследования.
     *
     * @return DtoListResultInterface
     *
     * @throws ExtendsMismatchException Исключение генерируется если установлен неправильный объект-результат.
     */
    public function getResult()
    {
        if (! is_object($this->result)) {
            throw new ExtendsMismatchException('Result must be an object');
        }
        if (! $this->result instanceof DtoListResultInterface) {
            throw new ExtendsMismatchException(get_class($this->result) . ' must implement ' . DtoListResultInterface::class);
        }
        return $this->result;
    }

    /**
     * Метод устанавливает объекта результат.
     *
     * @param DtoListResultInterface $result Новое значение.
     *
     * @return static
     */
    public function setResult(DtoListResultInterface $result)
    {
        $this->result = $result;
        return $this;
    }
}
