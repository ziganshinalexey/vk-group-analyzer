<?php

namespace Userstory\ComponentBase\caches;

use Exception;
use Userstory\ComponentBase\interfaces\AbstractCacheInterface;
use yii;
use yii\base\BaseObject;
use yii\db\Query;

/**
 * Класс AbstractActiveRecordCache реализовывает базовые методы для кеширования модели данных.
 *
 * @deprecated Следует использовать Userstory\Yii2Cache\caches\operations\SimpleQueryCache.
 *
 * @package Userstory\ComponentBase\caches
 */
class AbstractCache extends BaseObject implements AbstractCacheInterface
{
    const KEY_LIST = 'keys';

    /**
     * Свойство хранит префикс для ключей кеша.
     *
     * @var string|null
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\caches\operations\SimpleQueryCache.
     */
    protected $cacheKeyPrefix;

    /**
     * Метод задает значение префикс для ключей кеша.
     *
     * @param string $value Новое значение.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\caches\operations\SimpleQueryCache.
     *
     * @return void
     */
    public function setCacheKeyPrefix($value)
    {
        $this->cacheKeyPrefix = $value;
    }

    /**
     * Метод возвращает данные из кеша.
     *
     * @param Query   $query  Постротель запросов.
     * @param boolean $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @return array|false
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\caches\operations\SimpleQueryCache.
     *
     * @throws Exception Генерирует в случае неправильной работы кеша.
     */
    public function getFromCache(Query $query, $isMany = false)
    {
        $key = $this->keyBuild($query, $isMany);
        if (! $this->keyIsExists($key)) {
            return false;
        }
        $result = $this->getData($key);
        if (empty($result) && ! $isMany) {
            return false;
        }
        return $result;
    }

    /**
     * Метод кладет данные к кеш.
     *
     * @param Query   $query  Постротель запросов.
     * @param array   $value  Данные которые необходимо положить в кеш.
     * @param boolean $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\caches\operations\SimpleQueryCache.
     *
     * @return void
     */
    public function setToCache(Query $query, array $value, $isMany = false)
    {
        $key = $this->keyBuild($query, $isMany);
        if ($this->putData($key, $value)) {
            $keyList   = Yii::$app->cache->get($this->cacheKeyPrefix . self::KEY_LIST);
            $keyList[] = $key;
            $keyList   = array_unique($keyList);
            Yii::$app->cache->set($this->cacheKeyPrefix . self::KEY_LIST, $keyList);
        }
    }

    /**
     * Метод получения модели из кеша.
     *
     * @param string $cacheKey Ключ по которому получаем данные из кеша.
     *
     * @return false|array
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\caches\operations\SimpleQueryCache.
     *
     * @throws Exception, Генерирует в случае отсутстввия данных в кеше с таким именем формы.
     */
    protected function getData($cacheKey)
    {
        if (false === ( $data = Yii::$app->cache->get($cacheKey) )) {
            return false;
        }

        return $data;
    }

    /**
     * Метод кладет данные в кеш.
     *
     * @param string $cacheKey Имя ключа кеширования.
     * @param mixed  $value    Кешированное значение.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\caches\operations\SimpleQueryCache.
     *
     * @return boolean
     */
    protected function putData($cacheKey, $value)
    {
        return Yii::$app->cache->set($cacheKey, $value);
    }

    /**
     * Метод чистит кеш с префиксом объекта кеша.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\caches\operations\SimpleQueryCache.
     *
     * @return void
     */
    public function flush()
    {
        $keyList = Yii::$app->cache->get($this->cacheKeyPrefix . self::KEY_LIST);

        if (is_array($keyList)) {
            foreach ($keyList as $key) {
                $this->flushByKey($key);
            }
        }
    }

    /**
     * Метод возвращает флаг наличиия ключа для кеширования.
     *
     * @param string $key Название ключа, который необходимо найти.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\caches\operations\SimpleQueryCache.
     *
     * @return boolean
     */
    protected function keyIsExists($key)
    {
        $keyList = Yii::$app->cache->get($this->cacheKeyPrefix . self::KEY_LIST);
        if (! $keyList) {
            return false;
        }
        foreach ($keyList as $cachedKey) {
            if ($cachedKey === $key) {
                return true;
            }
        }
        return false;
    }

    /**
     * Метод сборки ключа по условию выборки из БД.
     *
     * @param Query   $query  условия выборки из БД.
     * @param boolean $isMany Флаг указывает на количество ожидаемых данных (много/один объект).
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\caches\operations\SimpleQueryCache.
     *
     * @return string
     */
    protected function keyBuild(Query $query, $isMany = false)
    {
        $rawSql = $query->createCommand()->rawSql;
        return md5($rawSql) . '-' . sha1($rawSql) . '-' . ( $isMany ? 'all' : 'one' );
    }

    /**
     * Метод поиска списка ключей по шаблону.
     *
     * @param string $pattern шаблон для поиска ключей.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\caches\operations\SimpleQueryCache.
     *
     * @return array
     */
    protected function findKey($pattern)
    {
        $keyList = Yii::$app->cache->get($this->cacheKeyPrefix . self::KEY_LIST);
        if (empty($keyList)) {
            return [];
        }
        return array_filter($keyList, function($item) use ($pattern) {
            return (bool)preg_match('/' . $pattern . '/', $item);
        });
    }

    /**
     * Метод удаляет тухлые данные из кеша.
     *
     * @param string $foulKey Ключ с тухлыми данными к кеше.
     *
     * @deprecated Следует использовать Userstory\Yii2Cache\caches\operations\SimpleQueryCache.
     *
     * @return void
     */
    protected function flushByKey($foulKey)
    {
        Yii::$app->cache->set($foulKey, false);
        $keyList = Yii::$app->cache->get($this->cacheKeyPrefix . self::KEY_LIST);
        if (empty($keyList)) {
            return;
        }
        if (false !== $key = array_search($foulKey, $keyList)) {
            unset($keyList[$key]);
        }
        Yii::$app->cache->set($this->cacheKeyPrefix . self::KEY_LIST, $keyList);
    }
}
