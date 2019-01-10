<?php

declare(strict_types = 1);

namespace Userstory\Database\interfaces;

use Userstory\Database\interfaces\queries\sql\BaseQueryInterface;

/**
 * Интерфейс объекта, работающего с прототипом объекта запроса.
 */
interface ObjectWithQueryInterface
{
    /**
     * Метод возвращает прототип объекта запроса.
     * Строгая типизация сознательно не использована с целью предоставить возможность
     * в дачерних интерфейсах указывать тип возвращаемого объекта.
     *
     * @return BaseQueryInterface
     */
    public function getQuery();

    /**
     * Метод устанавливает прототип объекта запроса.
     *
     * @param BaseQueryInterface $queryPrototype Новое значение.
     *
     * @return static
     */
    public function setQuery(BaseQueryInterface $queryPrototype);
}
