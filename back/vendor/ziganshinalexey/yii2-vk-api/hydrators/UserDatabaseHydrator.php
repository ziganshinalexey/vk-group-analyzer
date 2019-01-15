<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\hydrators;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Exceptions\exceptions\typeMismatch\ExtendsMismatchException;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;

/**
 * Гидратор для работы с сущностью "ВК пользователь" - преобразование в массив для записи в БД и обратно.
 */
class UserDatabaseHydrator implements HydratorInterface
{
    /**
     * Метод преобразует объект в обычный массив для записи в БД.
     *
     * @param UserInterface|null $item Объект для преобразования.
     *
     * @throws ExtendsMismatchException Если распаковывается объект, не имплементирующий нужный интерфейс.
     *
     * @return array
     */
    public function extract($item): array
    {
        if (! $item instanceof UserInterface) {
            throw new ExtendsMismatchException('Object must implement ' . UserInterface::class);
        }

        return [
            'firstName'      => $item->getFirstName(),
            'lastName'       => $item->getLastName(),
            'universityName' => $item->getUniversityName(),
            'facultyName'    => $item->getFacultyName(),
            'photo'          => $item->getPhoto(),
        ];
    }

    /**
     * Метод загружает данные в объект из массива БД.
     *
     * @param array|null         $data   Данные для загрузки в объект.
     * @param UserInterface|null $object Объект для загрузки данных.
     *
     * @throws ExtendsMismatchException Если распаковывается объект, не имплементирующий нужный интерфейс.
     *
     * @return UserInterface
     */
    public function hydrate($data, $object): UserInterface
    {
        if (! $object instanceof UserInterface) {
            throw new ExtendsMismatchException('Object must implement ' . UserInterface::class);
        }

        $object->setId((int)$data['id']);
        $object->setFirstName((string)$data['firstName']);
        $object->setLastName((string)$data['lastName']);
        $object->setUniversityName((string)$data['universityName']);
        $object->setFacultyName((string)$data['facultyName']);
        $object->setPhoto((string)$data['photo']);

        return $object;
    }
}
