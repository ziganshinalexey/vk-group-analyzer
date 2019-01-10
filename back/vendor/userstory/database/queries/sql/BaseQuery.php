<?php

declare(strict_types = 1);

namespace Userstory\Database\queries\sql;

use Userstory\Database\interfaces\queries\sql\BaseQueryInterface;
use yii\db\Query;
use function DeepCopy\deep_copy;

/**
 * Класс BaseSqlQuery.
 * Базовый класс запроса к базе данных.
 */
class BaseQuery extends Query implements BaseQueryInterface
{
    /**
     * Метод возвращает копию текущего объекта.
     * Строгая типизация сознательно опущена с целью дать возможность указывать тип возвращаемого значения в дочерних классах.
     *
     * @return BaseQueryInterface
     */
    public function copy()
    {
        return deep_copy($this);
    }
}
