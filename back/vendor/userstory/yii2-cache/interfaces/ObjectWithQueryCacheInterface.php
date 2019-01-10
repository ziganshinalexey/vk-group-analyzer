<?php

declare(strict_types = 1);

namespace Userstory\Yii2Cache\interfaces;

/**
 * Интефейс для объета, поддерживающего кэширования данных, полученных в результате запроса к БД сделанного операцией.
 */
interface ObjectWithQueryCacheInterface
{
    /**
     * Метод устанавливает модель кэшера.
     *
     * @param QueryCacheInterface $cacheModel Новое значение модели кэшера.
     *
     * @return static
     */
    public function setCacheModel(QueryCacheInterface $cacheModel);
}
