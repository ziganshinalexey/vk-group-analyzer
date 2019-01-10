<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\operations\keyword;

use Userstory\Database\traits\ObjectWithDbConnectionTrait;
use Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait;
use yii\base\InvalidConfigException;
use yii\base\Model;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\BaseFindOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\QueryInterface;
use Ziganshinalexey\Keyword\traits\keyword\DatabaseHydratorTrait;

/**
 * Операция поиска сущностей "Ключевое фраза" на основе фильтра.
 */
class BaseFindOperation extends Model implements BaseFindOperationInterface
{
    use ObjectWithDbConnectionTrait;
    use DatabaseHydratorTrait;
    use ObjectWithQueryCacheTrait;

    /**
     * Прототип объекта сущности.
     *
     * @var KeywordInterface|null
     */
    protected $keywordPrototype;

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
     * @return KeywordInterface[]
     */
    protected function getKeywordList(array $data): array
    {
        $result    = [];
        $prototype = $this->getKeywordPrototype();
        foreach ($data as $item) {
            $object   = $prototype->copy();
            $hydrator = $this->getKeywordDatabaseHydrator();
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
     * @return KeywordInterface
     */
    public function getKeywordPrototype(): KeywordInterface
    {
        if (null === $this->keywordPrototype) {
            throw new InvalidConfigException(__METHOD__ . '() KeywordPrototype prototype can not be empty');
        }
        return $this->keywordPrototype;
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
     * @param KeywordInterface $value Новое значение.
     *
     * @return BaseFindOperationInterface
     */
    public function setKeywordPrototype(KeywordInterface $value): BaseFindOperationInterface
    {
        $this->keywordPrototype = $value;
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
