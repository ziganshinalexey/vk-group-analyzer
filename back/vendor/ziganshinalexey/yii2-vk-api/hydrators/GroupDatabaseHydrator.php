<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\hydrators;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;

/**
 * Гидратор для работы с сущностью "ВК группа" - преобразование в массив для записи в БД и обратно.
 */
class GroupDatabaseHydrator implements HydratorInterface
{
    /**
     * Метод преобразует объект в обычный массив для записи в БД.
     *
     * @param GroupInterface|null $item Объект для преобразования.
     *
     * @throws ExtendsMismatchException Если распаковывается объект, не имплементирующий нужный интерфейс.
     *
     * @return array
     */
    public function extract($item): array
    {
        if (! $item instanceof GroupInterface) {
            throw new ExtendsMismatchException('Object must implement ' . GroupInterface::class);
        }

        return [
            'name'        => $item->getName(),
            'activity'    => $item->getActivity(),
            'description' => $item->getDescription(),
        ];
    }

    /**
     * Метод загружает данные в объект из массива БД.
     *
     * @param array|null          $data   Данные для загрузки в объект.
     * @param GroupInterface|null $object Объект для загрузки данных.
     *
     * @throws ExtendsMismatchException Если распаковывается объект, не имплементирующий нужный интерфейс.
     *
     * @return GroupInterface
     */
    public function hydrate($data, $object): GroupInterface
    {
        if (! $object instanceof GroupInterface) {
            throw new ExtendsMismatchException('Object must implement ' . GroupInterface::class);
        }

        $object->setId((int)$data['id']);
        $object->setName((string)$data['name']);
        $object->setActivity((string)$data['activity']);
        $object->setDescription((string)$data['description']);

        return $object;
    }
}
