<?php

declare(strict_types = 1);

namespace Userstory\Database\traits;

use Userstory\Database\interfaces\queries\sql\BaseQueryInterface;
use Userstory\Yii2Exceptions\exceptions\config\AttributeIsEmptyException;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use function get_class;

/**
 * Трейт объекта, работающего с объекта SQL запроса.
 */
trait ObjectWithQueryTrait
{
    /**
     * Прототип объекта запроса.
     *
     * @var BaseQueryInterface|null
     */
    protected $query;

    /**
     * Метод возвращает прототип объекта запроса.
     * Строгая типизация сознательно опущена с целью дать возможность указывать тип возвращаемого значения в дочерних объектах.
     *
     * @return BaseQueryInterface
     *
     * @throws AttributeIsEmptyException Исключение генерируется в случае, если объект прототип не установлен.
     * @throws ExtendsMismatchException Исключение генерируется если возвращается неверный тип объекта.
     */
    public function getQuery()
    {
        if (null === $this->query) {
            throw new AttributeIsEmptyException('Query can not be empty');
        }
        if (! $this->query instanceof BaseQueryInterface) {
            throw new ExtendsMismatchException(get_class($this->query) . ' must implement ' . BaseQueryInterface::class);
        }
        return $this->query;
    }

    /**
     * Метод устанавливает прототип объекта запроса.
     *
     * @param BaseQueryInterface $queryPrototype Новое значение.
     *
     * @return static
     */
    public function setQuery(BaseQueryInterface $queryPrototype)
    {
        $this->query = $queryPrototype;
        return $this;
    }
}
