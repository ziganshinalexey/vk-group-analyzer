<?php

declare(strict_types = 1);

namespace Userstory\Yii2Cache\traits;

use Userstory\Yii2Cache\exceptions\CacheNotFlushedException;
use Userstory\Yii2Cache\interfaces\QueryCacheInterface;
use yii\db\QueryInterface;

/**
 * Трейт для кэширования данных, полученных в результате запроса к БД сделанного операцией.
 */
trait ObjectWithQueryCacheTrait
{
    /**
     * Объект, отвечающий за логику кэширования данной сущности.
     *
     * @var QueryCacheInterface|null
     */
    protected $cacheModel;

    /**
     * Метод возвращает модель кэшера.
     *
     * @return QueryCacheInterface|null
     */
    protected function getCacheModel(): ?QueryCacheInterface
    {
        return $this->cacheModel;
    }

    /**
     * Метод устанавливает модель кэшера.
     *
     * @param QueryCacheInterface $cacheModel Новое значение модели кэшера.
     *
     * @return static
     */
    public function setCacheModel(QueryCacheInterface $cacheModel)
    {
        $this->cacheModel = $cacheModel;
        return $this;
    }

    /**
     * Метод возвращает данные из кэша если они там есть.
     *
     * @param QueryInterface $query  Постротель запросов к БД.
     * @param bool           $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @return mixed
     */
    protected function getFromCache(QueryInterface $query, bool $isMany = false)
    {
        if (null === $this->getCacheModel()) {
            return null;
        }
        return $this->getCacheModel()->get($query, $isMany);
    }

    /**
     * Метод помещает данные в кэш.
     *
     * @param QueryInterface $query  Постротель запросов к БД.
     * @param array          $value  Данные для сохранения к кэше.
     * @param bool           $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @return void
     */
    protected function setToCache(QueryInterface $query, array $value, bool $isMany = false): void
    {
        if (null === $this->getCacheModel()) {
            return;
        }
        $this->getCacheModel()->set($query, $value, $isMany);
    }

    /**
     * Метод сбрасывает кэш операции.
     *
     * @return void
     *
     * @throws CacheNotFlushedException Если не удалось очистить кэш.
     */
    protected function flushCache(): void
    {
        if (null === $this->getCacheModel()) {
            return;
        }
        $this->getCacheModel()->flush();
    }
}
