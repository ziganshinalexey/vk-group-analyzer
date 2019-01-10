<?php

declare(strict_types = 1);

namespace Userstory\ComponentBase\traits;

use Userstory\ComponentBase\interfaces\AbstractCacheInterface;
use yii\db\QueryInterface;

/**
 * Трейт для кэширования данных, полученных в результате запроса к БД сделанного операцией.
 *
 * @deprecated Следует использовать Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait.
 */
trait OperationCacheTrait
{
    /**
     * Объект, отвечающий за логику кэширования данной сущности.
     *
     * @var AbstractCacheInterface|null
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait.
     */
    protected $cacheModel;

    /**
     * Метод сбрасывает кэш операции.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait.
     *
     * @return static
     */
    protected function clearCache()
    {
        if (null !== $this->getCacheModel()) {
            $this->getCacheModel()->flush();
        }
        return $this;
    }

    /**
     * Метод возвращает модель кэшера.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait.
     *
     * @return AbstractCacheInterface|null
     */
    protected function getCacheModel(): ?AbstractCacheInterface
    {
        return $this->cacheModel;
    }

    /**
     * Метод возвращает данные из кэша если они там есть.
     *
     * @param QueryInterface $query  Постротель запросов к БД.
     * @param bool           $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait.
     *
     * @return mixed
     */
    protected function getFromCache(QueryInterface $query, bool $isMany = false)
    {
        if (null !== $this->getCacheModel()) {
            return $this->getCacheModel()->getFromCache($query, $isMany);
        }
        return false;
    }

    /**
     * Метод устанавливает модель кэшера.
     *
     * @param AbstractCacheInterface $cacheModel Новое значение модели кэшера.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait.
     *
     * @return static
     */
    public function setCacheModel(AbstractCacheInterface $cacheModel)
    {
        $this->cacheModel = $cacheModel;
        return $this;
    }

    /**
     * Метод помещает данные в кэш.
     *
     * @param QueryInterface $query  Постротель запросов к БД.
     * @param array          $value  Данные для сохранения к кэше.
     * @param bool           $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\traits\ObjectWithQueryCacheTrait.
     *
     * @return void
     */
    protected function setToCache(QueryInterface $query, array $value, bool $isMany = false): void
    {
        if (null !== $this->getCacheModel()) {
            $this->getCacheModel()->setToCache($query, $value, $isMany);
        }
    }
}
