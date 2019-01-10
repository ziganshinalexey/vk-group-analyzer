<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\api\v1\hydrators\keyword;

use ReflectionException;
use Userstory\ComponentHydrator\hydrators\ArrayHydrator;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;

/**
 * Гидратор для работы с сущностью "Ключевое фраза".
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
        if (! $object instanceof KeywordInterface) {
            throw new ExtendsMismatchException('Object must implement ' . KeywordInterface::class);
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
     * @return KeywordInterface
     */
    public function hydrate($data, $object): KeywordInterface
    {
        if (! $object instanceof KeywordInterface) {
            throw new ExtendsMismatchException('Object must implement ' . KeywordInterface::class);
        }
        return parent::hydrate($data, $object);
    }
}
