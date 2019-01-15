<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\operations\group;

use Userstory\Database\traits\ObjectWithDbConnectionTrait;
use Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait;
use yii\base\InvalidConfigException;
use yii\base\Model;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\BaseFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\QueryInterface;
use Ziganshinalexey\Yii2VkApi\traits\group\DatabaseHydratorTrait;

/**
 * Операция поиска сущностей "ВК группа" на основе фильтра.
 */
class BaseFindOperation extends Model implements BaseFindOperationInterface
{
    use ObjectWithDbConnectionTrait;
    use DatabaseHydratorTrait;
    use ObjectWithQueryCacheTrait;

    /**
     * Прототип объекта сущности.
     *
     * @var GroupInterface|null
     */
    protected $groupPrototype;

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
     * @return GroupInterface[]
     */
    protected function getGroupList(array $data): array
    {
        $result    = [];
        $prototype = $this->getGroupPrototype();
        foreach ($data as $item) {
            $object   = $prototype->copy();
            $hydrator = $this->getGroupDatabaseHydrator();
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
     * @return GroupInterface
     */
    public function getGroupPrototype(): GroupInterface
    {
        if (null === $this->groupPrototype) {
            throw new InvalidConfigException(__METHOD__ . '() GroupPrototype prototype can not be empty');
        }
        return $this->groupPrototype;
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
     * @param GroupInterface $value Новое значение.
     *
     * @return BaseFindOperationInterface
     */
    public function setGroupPrototype(GroupInterface $value): BaseFindOperationInterface
    {
        $this->groupPrototype = $value;
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
