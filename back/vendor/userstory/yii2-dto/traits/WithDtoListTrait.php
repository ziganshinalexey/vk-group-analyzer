<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\traits;

use Userstory\Yii2Dto\interfaces\BaseDtoInterface;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use function get_class;

/**
 * Трейт объекта, который работает со списком ДТО.
 */
trait WithDtoListTrait
{
    /**
     * Список ДТО сущностей для обработки.
     *
     * @var BaseDtoInterface[]
     */
    protected $dtoList = [];

    /**
     * Метод возвращает список ДТО сущностей.
     *
     * @return BaseDtoInterface[]
     */
    public function getDtoList(): array
    {
        return $this->dtoList;
    }

    /**
     * Метод устанавливает список ДТО сущностей.
     *
     * @param BaseDtoInterface[] $dtoList Список ДТО сущностей.
     *
     * @return static
     *
     * @throws ExtendsMismatchException Ичключение генерируется в случае, если элемент списка ДТО не является ДТО.
     */
    public function setDtoList(array $dtoList)
    {
        foreach ($dtoList as $dto) {
            if (! $dto instanceof BaseDtoInterface) {
                throw new ExtendsMismatchException(get_class($dto) . ' must implement ' . BaseDtoInterface::class);
            }
        }
        $this->dtoList = $dtoList;
        return $this;
    }
}
