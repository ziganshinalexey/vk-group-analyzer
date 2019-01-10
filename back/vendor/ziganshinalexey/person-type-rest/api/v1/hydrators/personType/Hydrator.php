<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\api\v1\hydrators\personType;

use ReflectionException;
use Userstory\ComponentHydrator\hydrators\ArrayHydrator;
use Userstory\Yii2Exceptions\exceptions\typeMismatch\ExtendsMismatchException;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;

/**
 * Гидратор для работы с сущностью "Тип личности".
 */
class Hydrator extends ArrayHydrator
{
    /**
     * Метод преобразует объект в обычный массив.
     *
     * @param mixed $object Объект для преобразования.
     *
     * @throws ExtendsMismatchException Если распаковывается объект, не имплементирующий нужный интерфейс.
     * @throws ReflectionException      Если преобразуемый класс отсутствует.
     *
     * @inherit
     *
     * @return array
     */
    public function extract($object): array
    {
        if (! $object instanceof PersonTypeInterface) {
            throw new ExtendsMismatchException('Object must implement ' . PersonTypeInterface::class);
        }
        return parent::extract($object);
    }

    /**
     * Метод загружает данные в объект из массива.
     *
     * @param mixed $data   Данные для загрузки в объект.
     * @param mixed $object Объект для загрузки данных.
     *
     * @throws ExtendsMismatchException Если распаковывается объект, не имплементирующий нужный интерфейс.
     * @throws ReflectionException      Если преобразуемый класс отсутствует.
     *
     * @inherit
     *
     * @return PersonTypeInterface
     */
    public function hydrate($data, $object): PersonTypeInterface
    {
        if (! $object instanceof PersonTypeInterface) {
            throw new ExtendsMismatchException('Object must implement ' . PersonTypeInterface::class);
        }
        return parent::hydrate($data, $object);
    }
}
