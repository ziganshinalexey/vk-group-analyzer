<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\api\v1\formatters\keyword;

use Userstory\ComponentHydrator\formatters\ArrayFormatter;

/**
 * Форматтер данных для возврата из REST-метода удаления сущности "Ключевое фраза".
 */
class DeleteFormatter extends ArrayFormatter
{
    /**
     * Метод преобразует объект в обычный массив и убирает данные, которых не должно быть в ответе.
     *
     * @param mixed $object Объект для форматирования.
     *
     * @inherit
     *
     * @return array
     */
    public function format($object): array
    {
        return ['success' => true];
    }
}
