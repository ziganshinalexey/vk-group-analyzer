<?php

namespace Userstory\ComponentBase\interfaces;

use yii\db\Query;

/**
 * Интерфейс AbstractCacheInterface объявляет реализацию класса кеша.
 *
 * @deprecated Следует использовать Userstory\Yii2Cache\interfaces\QueryCacheInterface.
 *
 * @package Userstory\ComponentBase\interfaces
 */
interface AbstractCacheInterface
{
    /**
     * Метод задает значение префикс для ключей кеша.
     *
     * @param string $value Новое значение.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\interfaces\QueryCacheInterface.
     *
     * @return void
     */
    public function setCacheKeyPrefix($value);

    /**
     * Метод возвращает данные из кеша.
     *
     * @param Query   $query  Постротель запросов.
     * @param boolean $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\interfaces\QueryCacheInterface.
     *
     * @return mixed|false
     */
    public function getFromCache(Query $query, $isMany = false);

    /**
     * Метод кладет данные к кеш.
     *
     * @param Query   $query  Постротель запросов.
     * @param array   $value  Данные которые необходимо положить в кеш.
     * @param boolean $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\interfaces\QueryCacheInterface.
     *
     * @return bool
     */
    public function setToCache(Query $query, array $value, $isMany = false);

    /**
     * Метод чистит кеш с префиксом объекта кеша.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\interfaces\QueryCacheInterface.
     *
     * @return bool
     */
    public function flush();
}
