<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\api\v1\hydrators\personType;

use ReflectionException;
use Userstory\ComponentHydrator\hydrators\ArrayHydrator;
use Userstory\Yii2Exceptions\exceptions\typeMismatch\ExtendsMismatchException;
use Ziganshinalexey\PersonType\interfaces\personType\filters\MultiFilterInterface;

/**
 * Гидратор для работы с с фильтром сущности "Тип личности".
 */
class FilterHydrator extends ArrayHydrator
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
        if (! $object instanceof MultiFilterInterface) {
            throw new ExtendsMismatchException('Object must implement ' . MultiFilterInterface::class);
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
     * @return MultiFilterInterface
     */
    public function hydrate($data, $object): MultiFilterInterface
    {
        if (! $object instanceof MultiFilterInterface) {
            throw new ExtendsMismatchException('Object must implement ' . MultiFilterInterface::class);
        }
        $filter = $data['filter'] ?? [];
        return parent::hydrate($filter, $object);
    }
}
