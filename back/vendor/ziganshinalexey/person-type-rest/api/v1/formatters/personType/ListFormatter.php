<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\api\v1\formatters\personType;

use ReflectionException;
use Userstory\ComponentHydrator\formatters\ArrayFormatter;

/**
 * Форматтер данных для возврата из REST-метода поиска сущностей "Тип личности".
 */
class ListFormatter extends ArrayFormatter
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
        $result = [];
        /* @var array $object */
        foreach ($object as $item) {
            $data = parent::format($item);
            unset($data['updaterId'], $data['updateDate']);
            $result[] = $data;
        }
        return $result;
    }
}
