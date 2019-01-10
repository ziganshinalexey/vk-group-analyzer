<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\hydrators;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Exceptions\exceptions\typeMismatch\ExtendsMismatchException;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;

/**
 * Гидратор для работы с сущностью "Тип личности" - преобразование в массив для записи в БД и обратно.
 */
class PersonTypeDatabaseHydrator implements HydratorInterface
{
    /**
     * Метод преобразует объект в обычный массив для записи в БД.
     *
     * @param PersonTypeInterface|null $item Объект для преобразования.
     *
     * @throws ExtendsMismatchException Если распаковывается объект, не имплементирующий нужный интерфейс.
     *
     * @return array
     */
    public function extract($item): array
    {
        if (! $item instanceof PersonTypeInterface) {
            throw new ExtendsMismatchException('Object must implement ' . PersonTypeInterface::class);
        }

        return [
            'name' => $item->getName(),
        ];
    }

    /**
     * Метод загружает данные в объект из массива БД.
     *
     * @param array|null               $data   Данные для загрузки в объект.
     * @param PersonTypeInterface|null $object Объект для загрузки данных.
     *
     * @throws ExtendsMismatchException Если распаковывается объект, не имплементирующий нужный интерфейс.
     *
     * @return PersonTypeInterface
     */
    public function hydrate($data, $object): PersonTypeInterface
    {
        if (! $object instanceof PersonTypeInterface) {
            throw new ExtendsMismatchException('Object must implement ' . PersonTypeInterface::class);
        }

        $object->setId((int)$data['id']);
        $object->setName((string)$data['name']);

        return $object;
    }
}
