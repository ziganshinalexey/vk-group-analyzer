<?php

declare(strict_types = 1);

namespace Userstory\Yii2Cache\interfaces;

use yii\db\QueryInterface;

/**
 * Интерфейс OperationCacheInterface объявляет реализацию класса кеша для операции.
 */
interface QueryCacheInterface
{
    /**
     * Метод возвращает данные из кеша.
     *
     * @param QueryInterface $query  Постротель запросов.
     * @param bool           $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @return mixed
     */
    public function get(QueryInterface $query, bool $isMany = false);

    /**
     * Метод помещает данные к кеш.
     *
     * @param QueryInterface $query  Постротель запросов.
     * @param mixed          $value  Данные которые необходимо положить в кеш.
     * @param bool           $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @return void
     */
    public function set(QueryInterface $query, $value, bool $isMany = false): void;

    /**
     * Метод чистит кеш с префиксом объекта кеша.
     *
     * @return void
     */
    public function flush(): void;
}
