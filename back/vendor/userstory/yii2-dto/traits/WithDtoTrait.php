<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\traits;

use Userstory\Yii2Dto\interfaces\BaseDtoInterface;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use function get_class;
use function is_object;

/**
 * Трейт объекта, который работает с ДТО.
 */
trait WithDtoTrait
{
    /**
     * Объект ДТО для обработки.
     *
     * @var BaseDtoInterface|null
     */
    protected $dto;

    /**
     * Метод возвращает ДТО сущности.
     * Строгой типизации нет специально для возможности наследования.
     *
     * @return BaseDtoInterface|null
     *
     * @throws ExtendsMismatchException Исключение генерируется если установлен неправильный объект-дто.
     */
    public function getDto()
    {
        if (null !== $this->dto && ! is_object($this->dto)) {
            throw new ExtendsMismatchException('Dto must be an object');
        }
        if (null !== $this->dto && ! $this->dto instanceof BaseDtoInterface) {
            throw new ExtendsMismatchException(get_class($this->dto) . ' must implement ' . BaseDtoInterface::class);
        }
        return $this->dto;
    }

    /**
     * Метод устанавливает ДТО сущности.
     *
     * @param BaseDtoInterface|null $dto Новое значение.
     *
     * @return static
     */
    public function setDto(?BaseDtoInterface $dto)
    {
        $this->dto = $dto;
        return $this;
    }
}
