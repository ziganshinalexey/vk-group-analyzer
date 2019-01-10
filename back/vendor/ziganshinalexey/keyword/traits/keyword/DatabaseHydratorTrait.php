<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\traits\keyword;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\hydrators\KeywordDatabaseHydrator;

/**
 * Трейт, содержащий логику доступа к гидратору сущности "Ключевое фраза" в массив для записи в БД и обратно.
 */
trait DatabaseHydratorTrait
{
    /**
     * Экземпляр объекта гидратора для работы с БД сущности "Ключевое фраза".
     *
     * @var KeywordDatabaseHydrator|null
     */
    protected $keywordDatabaseHydrator;

    /**
     * Метод возвращает объект гидратора сущности "Ключевое фраза" в массив для записи в БД и обратно.
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @return HydratorInterface
     */
    protected function getKeywordDatabaseHydrator(): HydratorInterface
    {
        if (null === $this->keywordDatabaseHydrator) {
            throw new InvalidConfigException('Hydrator object can not be null');
        }
        return $this->keywordDatabaseHydrator;
    }

    /**
     * Метод задает значение гидратора сущности "Ключевое фраза" в массив для записи в БД и обратно.
     *
     * @param HydratorInterface $hydrator Объект класса преобразователя.
     *
     * @return static
     */
    public function setKeywordDatabaseHydrator(HydratorInterface $hydrator)
    {
        $this->keywordDatabaseHydrator = $hydrator;
        return $this;
    }
}
