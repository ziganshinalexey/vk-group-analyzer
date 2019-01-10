<?php

declare(strict_types = 1);

namespace Userstory\Yii2Cache\caches\operations;

use Exception;
use Userstory\Yii2Cache\exceptions\CacheFlushTimeNotSettedException;
use Userstory\Yii2Cache\exceptions\CacheNotFlushedException;
use Userstory\Yii2Cache\exceptions\CacheNotSettedException;
use Userstory\Yii2Cache\interfaces\QueryCacheInterface;
use Userstory\Yii2Exceptions\exceptions\types\ExtendsMismatchException;
use yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use yii\caching\CacheInterface;
use yii\db\Query;
use yii\db\QueryInterface;
use function md5;
use function microtime;
use function random_int;
use function sha1;

/**
 * Класс OperationCache реализовывает базовые методы для кеширования результатов работы операций.
 */
class SimpleQueryCache extends BaseObject implements QueryCacheInterface
{
    protected const FLUSH_DATE_TIME_KEY = '_flush_date_time';

    /**
     * Свойство хранит префикс для ключей кеша.
     *
     * @var string
     */
    protected $keyPrefix = '';

    /**
     * Время, на которое выполняется кеширование.
     *
     * @var int
     */
    protected $duration = 3600;

    /**
     * Разброс от времени, на которое выполняется кеширование.
     *
     * @var int
     */
    protected $dispersion = 120;

    /**
     * Запрещать ли кеширование.
     *
     * @var bool
     */
    protected $disableCache = false;

    /**
     * Объект для работы с кешем.
     *
     * @var CacheInterface|null
     */
    protected $cache;

    /**
     * Значение времени последнего сброса кеша.
     *
     * @var string
     */
    protected $flushTimeValue = '';

    /**
     * Получить разброс от времени, на которое выполняется кеширование.
     *
     * @return int
     */
    public function getDispersion(): int
    {
        return (int)$this->dispersion;
    }

    /**
     * Установить разброс от времени, на которое выполняется кеширование.
     *
     * @param int $dispersion Новое значение.
     *
     * @return static
     */
    public function setDispersion(int $dispersion): self
    {
        $this->dispersion = $dispersion;
        return $this;
    }

    /**
     * Получить время, на которое выполняется кеширование.
     *
     * @return int
     */
    public function getDuration(): int
    {
        return (int)$this->duration;
    }

    /**
     * Установить время, на которое выполняется кеширование.
     *
     * @param int $duration Новое значение.
     *
     * @return static
     */
    public function setDuration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * Метод задает значение префикс для ключей кеша.
     *
     * @param string $value Новое значение.
     *
     * @return static
     */
    public function setKeyPrefix(string $value): self
    {
        $this->keyPrefix = $value;
        return $this;
    }

    /**
     * Метод получает значение префикса для ключей кеша.
     *
     * @throws InvalidConfigException Исключение генерируется если прификс не задан.
     *
     * @return string
     */
    public function getKeyPrefix(): string
    {
        if ('' === $this->keyPrefix) {
            throw new InvalidConfigException(__METHOD__ . '() keyPrefix can not be empty');
        }
        return (string)$this->keyPrefix;
    }

    /**
     * Метод устанавливает объект для работы с кешом.
     *
     * @param CacheInterface $cache Новое значение.
     *
     * @return static
     */
    public function setCache(CacheInterface $cache): self
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * Метод получает объект для работы с кешем.
     *
     * @return CacheInterface
     */
    public function getCache(): CacheInterface
    {
        if (null === $this->cache) {
            $this->cache = Yii::$app->getCache();
        }
        return $this->cache;
    }

    /**
     * Получить флаг необходимости отключить кеш.
     *
     * @return bool
     */
    public function getDisableCache(): bool
    {
        return (bool)$this->disableCache;
    }

    /**
     * Установить флаг необходимости отключить кеш.
     *
     * @param bool $disableCache Новое значение.
     *
     * @return static
     */
    public function setDisableCache(bool $disableCache): self
    {
        $this->disableCache = $disableCache;
        return $this;
    }

    /**
     * Публичный метод-обертка для получения данных из кэша.
     *
     * @param QueryInterface $query  Постротель запросов.
     * @param bool           $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @throws InvalidConfigException Исключение генерируется если кеш не задан.
     * @throws ExtendsMismatchException Исключение генерируется если кеш задан некорректно.
     *
     * @return mixed|null
     */
    public function get(QueryInterface $query, bool $isMany = false)
    {
        try {
            return $this->getFromCache($query, $isMany);
        } catch (CacheFlushTimeNotSettedException $exception) {
            return null;
        }
    }

    /**
     * Метод возвращает данные из кеша.
     *
     * @param QueryInterface $query  Постротель запросов.
     * @param bool           $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @throws InvalidConfigException Исключение генерируется если кеш не задан.
     * @throws ExtendsMismatchException Исключение генерируется если кеш задан некорректно.
     * @throws CacheFlushTimeNotSettedException Если не удалось установить время жизни кэша.
     *
     * @return mixed|null
     */
    protected function getFromCache(QueryInterface $query, bool $isMany = false)
    {
        if ($this->getDisableCache()) {
            return null;
        }

        $key = $this->buildKey($query, $isMany);

        $result = $this->getCache()->get($key);
        return false === $result ? null : $result;
    }

    /**
     * Метод помещает данные к кеш.
     *
     * @param QueryInterface $query  Постротель запросов.
     * @param mixed          $value  Данные которые необходимо положить в кеш.
     * @param bool           $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @throws InvalidConfigException Исключение генерируется если кеш не задан.
     * @throws ExtendsMismatchException Исключение генерируется если кеш задан некорректно.
     * @throws Exception Если не удалось сгенерировать случайное число.
     * @throws CacheNotSettedException Если не удалось установить кэш.
     * @throws CacheFlushTimeNotSettedException Если не удалось установить время жизни кэша.
     *
     * @return void
     */
    public function set(QueryInterface $query, $value, bool $isMany = false): void
    {
        if ($this->getDisableCache()) {
            return;
        }

        $key          = $this->buildKey($query, $isMany);
        $realDuration = $this->getDuration() + random_int(0, $this->getDispersion());
        if ($this->getCache()->set($key, $value, $realDuration)) {
            return;
        }

        throw new CacheNotSettedException('Can not set value to cache');
    }

    /**
     * Метод чистит кеш с префиксом объекта кеша.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной конфигурации.
     * @throws CacheNotFlushedException Если не удалось очистить кэш.
     * @throws CacheFlushTimeNotSettedException Если не удалось установить время жизни кэша.
     *
     * @return void
     */
    public function flush(): void
    {
        if ($this->getDisableCache()) {
            return;
        }

        if (null !== $this->refreshFlushTime()) {
            return;
        }

        throw new CacheNotFlushedException('Can not flush cache');
    }

    /**
     * Получить ключ, по которому храниться дата последнего сброса кеша.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной конфигурации кеша.
     *
     * @return string
     */
    protected function getFlushDateTimeKey(): string
    {
        return $this->getKeyPrefix() . static::FLUSH_DATE_TIME_KEY;
    }

    /**
     * Получить новое значение времени сброса кеша.
     *
     * @return string
     */
    protected function getNewFlushDateTimeValue(): string
    {
        return (string)microtime();
    }

    /**
     * Метод получает время последнего сброса кеша.
     *
     * @throws InvalidConfigException Исключение генерируется если кеш не задан.
     * @throws CacheFlushTimeNotSettedException Если не удалось установить время жизни кэша.
     *
     * @return string
     */
    protected function getFlushTime(): string
    {
        $cache            = $this->getCache();
        $flushDateTimeKey = $this->getFlushDateTimeKey();
        if (false === $oldFlushDateTimeValue = $cache->get($flushDateTimeKey)) {
            return $this->refreshFlushTime();
        }
        return (string)$oldFlushDateTimeValue;
    }

    /**
     * Метод обновляет время сброса кеша.
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной конфигурации.
     * @throws CacheFlushTimeNotSettedException Если не удалось установить время жизни кэша.
     *
     * @return string
     */
    protected function refreshFlushTime(): string
    {
        $cache                 = $this->getCache();
        $flushDateTimeKey      = $this->getFlushDateTimeKey();
        $newFlushDateTimeValue = $this->getNewFlushDateTimeValue();

        if ($cache->set($flushDateTimeKey, $newFlushDateTimeValue)) {
            return $newFlushDateTimeValue;
        }

        throw new CacheFlushTimeNotSettedException('Can not set cache flush time');
    }

    /**
     * Метод сборки ключа по условию выборки из БД.
     *
     * @param QueryInterface $query  условия выборки из БД.
     * @param bool           $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @throws InvalidConfigException Исключение генерируется если кеш не задан.
     * @throws ExtendsMismatchException Исключение генерируется если кеш задан некорректно.
     * @throws CacheFlushTimeNotSettedException Если не удалось установить время жизни кэша.
     *
     * @return string
     */
    protected function buildKey(QueryInterface $query, bool $isMany = false): string
    {
        if (! $query instanceof Query) {
            throw new ExtendsMismatchException(__METHOD__ . '() query must extends ' . Query::class);
        }

        $prefix  = $this->getFlushTime();
        $postfix = $isMany ? 'all' : 'one';
        $rawSql  = $query->createCommand()->getRawSql();
        return $prefix . '-' . md5($rawSql) . '-' . sha1($rawSql) . '-' . $postfix;
    }
}
