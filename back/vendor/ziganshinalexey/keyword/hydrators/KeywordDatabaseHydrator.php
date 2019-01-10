<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\hydrators;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Exceptions\exceptions\typeMismatch\ExtendsMismatchException;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;

/**
 * Гидратор для работы с сущностью "Ключевое фраза" - преобразование в массив для записи в БД и обратно.
 */
class KeywordDatabaseHydrator implements HydratorInterface
{
    /**
     * Метод преобразует объект в обычный массив для записи в БД.
     *
     * @param KeywordInterface|null $item Объект для преобразования.
     *
     * @throws ExtendsMismatchException Если распаковывается объект, не имплементирующий нужный интерфейс.
     *
     * @return array
     */
    public function extract($item): array
    {
        if (! $item instanceof KeywordInterface) {
            throw new ExtendsMismatchException('Object must implement ' . KeywordInterface::class);
        }

        return [
            'text'         => $item->getText(),
            'personTypeId' => $item->getPersonTypeId(),
        ];
    }

    /**
     * Метод загружает данные в объект из массива БД.
     *
     * @param array|null            $data   Данные для загрузки в объект.
     * @param KeywordInterface|null $object Объект для загрузки данных.
     *
     * @throws ExtendsMismatchException Если распаковывается объект, не имплементирующий нужный интерфейс.
     *
     * @return KeywordInterface
     */
    public function hydrate($data, $object): KeywordInterface
    {
        if (! $object instanceof KeywordInterface) {
            throw new ExtendsMismatchException('Object must implement ' . KeywordInterface::class);
        }

        $object->setId((int)$data['id']);
        $object->setText((string)$data['text']);
        $object->setPersonTypeId((int)$data['personTypeId']);

        return $object;
    }
}
