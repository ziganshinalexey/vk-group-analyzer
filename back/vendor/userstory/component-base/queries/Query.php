<?php

namespace Userstory\ComponentBase\queries;

use Userstory\ComponentBase\interfaces\PrototypeInterface;
use yii\db\Query as YiiQuery;

/**
 * Класс Query.
 * Класс для построения селект запросов.
 *
 * @package Userstory\ComponentBase\models
 */
class Query extends YiiQuery implements PrototypeInterface
{
    /**
     * Метод возвращает копию текущего объекта.
     *
     * @return static
     */
    public function copy()
    {
        return new static([
            'where'        => $this->where,
            'limit'        => $this->limit,
            'offset'       => $this->offset,
            'orderBy'      => $this->orderBy,
            'indexBy'      => $this->indexBy,
            'select'       => $this->select,
            'selectOption' => $this->selectOption,
            'distinct'     => $this->distinct,
            'from'         => $this->from,
            'groupBy'      => $this->groupBy,
            'join'         => $this->join,
            'having'       => $this->having,
            'union'        => $this->union,
            'params'       => $this->params,
        ]);
    }
}
