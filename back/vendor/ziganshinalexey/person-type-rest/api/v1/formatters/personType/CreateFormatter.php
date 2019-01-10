<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\api\v1\formatters\personType;

use ReflectionException;
use Userstory\ComponentHydrator\formatters\ArrayFormatter;

/**
 * Форматтер данных для возврата из REST-метода создания сущности "Тип личности".
 */
class CreateFormatter extends ArrayFormatter
{
    /**
     * Метод преобразует объект в обычный массив и убирает данные, которых не должно быть в ответе.
     *
     * @param mixed $object Объект для форматирования.
     *
     * @throws ReflectionException Генерирует, если класс отсутствует.
     *
     * @inherit
     *
     * @return array
     */
    public function format($object): array
    {
        $data = parent::format($object);
        unset($data['updaterId'], $data['updateDate']);
        return $data;
    }
}
