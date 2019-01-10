<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\operations\personType;

use Userstory\Database\traits\ObjectWithDbConnectionTrait;
use Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait;
use yii\base\InvalidConfigException;
use yii\base\Model;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\BaseFindOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\QueryInterface;
use Ziganshinalexey\PersonType\traits\personType\DatabaseHydratorTrait;

/**
 * Операция поиска сущностей "Тип личности" на основе фильтра.
 */
class BaseFindOperation extends Model implements BaseFindOperationInterface
{
    use ObjectWithDbConnectionTrait;
    use DatabaseHydratorTrait;
    use ObjectWithQueryCacheTrait;

    /**
     * Прототип объекта сущности.
     *
     * @var PersonTypeInterface|null
     */
    protected $personTypePrototype;

    /**
     * Объект запрос к базе данных.
     *
     * @var QueryInterface|null
     */
    protected $query;

    /**
     * Метод строит запрос дял получения сущностей, добавляя в него необходимые параметры.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return QueryInterface
     */
    protected function buildQuery(): QueryInterface
    {
        return $this->getQuery();
    }

    /**
     * Метод создает из полученных из базы данных объекты сущностей.
     *
     * @param array $data Данные из базы данных.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return PersonTypeInterface[]
     */
    protected function getPersonTypeList(array $data): array
    {
        $result    = [];
        $prototype = $this->getPersonTypePrototype();
        foreach ($data as $item) {
            $object   = $prototype->copy();
            $hydrator = $this->getPersonTypeDatabaseHydrator();
            $object   = $hydrator->hydrate($item, $object);

            $result[$object->getId()] = $object;
        }
        return $result;
    }

    /**
     * Метод возвращает сущность, над которой нужно выполнить операцию.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return PersonTypeInterface
     */
    public function getPersonTypePrototype(): PersonTypeInterface
    {
        if (null === $this->personTypePrototype) {
            throw new InvalidConfigException(__METHOD__ . '() PersonTypePrototype prototype can not be empty');
        }
        return $this->personTypePrototype;
    }

    /**
     * Метод возвращает объект запрос к базе данных.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return QueryInterface
     */
    protected function getQuery(): QueryInterface
    {
        if (null === $this->query) {
            throw new InvalidConfigException(__METHOD__ . '() Query can not be empty');
        }
        return $this->query;
    }

    /**
     * Метод устанавливает сущность, над которой необходимо выполнить операцию.
     *
     * @param PersonTypeInterface $value Новое значение.
     *
     * @return BaseFindOperationInterface
     */
    public function setPersonTypePrototype(PersonTypeInterface $value): BaseFindOperationInterface
    {
        $this->personTypePrototype = $value;
        return $this;
    }

    /**
     * Метод устанавливает объект запрос к базе данных.
     *
     * @param QueryInterface $query Новое значение.
     *
     * @return BaseFindOperationInterface
     */
    public function setQuery(QueryInterface $query): BaseFindOperationInterface
    {
        $this->query = $query;
        return $this;
    }
}
