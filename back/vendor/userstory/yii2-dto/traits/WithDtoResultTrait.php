<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\traits;

use Userstory\Yii2Dto\interfaces\results\DtoResultInterface;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use function get_class;
use function is_object;

/**
 * Трейт объекта, работающего через результат с ДТО.
 */
trait WithDtoResultTrait
{
    /**
     * Объект класса-результата для работы.
     *
     * @var DtoResultInterface|null
     */
    protected $result;

    /**
     * Метод возвращает объекта результат.
     * Строгой типизации нет специально для возможности наследования.
     *
     * @return DtoResultInterface
     *
     * @throws ExtendsMismatchException Исключение генерируется если установлен неправильный объект-результат.
     */
    public function getResult()
    {
        if (! is_object($this->result)) {
            throw new ExtendsMismatchException('Result must be an object');
        }
        if (! $this->result instanceof DtoResultInterface) {
            throw new ExtendsMismatchException(get_class($this->result) . ' must implement ' . DtoResultInterface::class);
        }
        return $this->result;
    }

    /**
     * Метод устанавливает объекта результат.
     *
     * @param DtoResultInterface $result Новое значение.
     *
     * @return static
     */
    public function setResult(DtoResultInterface $result)
    {
        $this->result = $result;
        return $this;
    }
}
