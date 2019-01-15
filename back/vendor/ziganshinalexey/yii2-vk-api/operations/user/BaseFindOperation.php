<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\operations\user;

use Userstory\Database\traits\ObjectWithDbConnectionTrait;
use Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait;
use yii\base\InvalidConfigException;
use yii\base\Model;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\BaseFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\QueryInterface;
use Ziganshinalexey\Yii2VkApi\traits\user\DatabaseHydratorTrait;

/**
 * Операция поиска сущностей "ВК пользователь" на основе фильтра.
 */
class BaseFindOperation extends Model implements BaseFindOperationInterface
{
    use ObjectWithDbConnectionTrait;
    use DatabaseHydratorTrait;
    use ObjectWithQueryCacheTrait;

    /**
     * Объект запрос к базе данных.
     *
     * @var QueryInterface|null
     */
    protected $query;

    /**
     * Прототип объекта сущности.
     *
     * @var UserInterface|null
     */
    protected $userPrototype;

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
     * Метод создает из полученных из базы данных объекты сущностей.
     *
     * @param array $data Данные из базы данных.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной инициализации команды.
     *
     * @return UserInterface[]
     */
    protected function getUserList(array $data): array
    {
        $result    = [];
        $prototype = $this->getUserPrototype();
        foreach ($data as $item) {
            $object   = $prototype->copy();
            $hydrator = $this->getUserDatabaseHydrator();
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
     * @return UserInterface
     */
    public function getUserPrototype(): UserInterface
    {
        if (null === $this->userPrototype) {
            throw new InvalidConfigException(__METHOD__ . '() UserPrototype prototype can not be empty');
        }
        return $this->userPrototype;
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

    /**
     * Метод устанавливает сущность, над которой необходимо выполнить операцию.
     *
     * @param UserInterface $value Новое значение.
     *
     * @return BaseFindOperationInterface
     */
    public function setUserPrototype(UserInterface $value): BaseFindOperationInterface
    {
        $this->userPrototype = $value;
        return $this;
    }
}
