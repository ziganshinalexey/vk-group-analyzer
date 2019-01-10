<?php

namespace Userstory\I18n\operations;

use Exception;
use Userstory\ComponentBase\interfaces\ActiveRecordCacheInterface;
use Userstory\I18n\interfaces\LanguageGetInterface;
use Userstory\I18n\interfaces\LanguageInterface;
use Userstory\I18n\queries\LanguageQuery;
use yii;
use yii\base\InvalidValueException;

/**
 * Класс LanguageGetOperations реализует методы получения языков.
 *
 * @package Userstory\I18n\operations
 */
class LanguageGetOperation implements LanguageGetInterface
{
    /**
     * Свойство хранит объект кеширования.
     *
     * @var ActiveRecordCacheInterface|null
     */
    protected $cacheModel;

    /**
     * Свойство хранит объект построителя запросов.
     *
     * @var LanguageQuery|null
     */
    protected $query;

    /**
     * Метод задает значение свойству кеша.
     *
     * @param ActiveRecordCacheInterface $cacheModel Новое значение.
     *
     * @return void
     */
    public function setCacheModel(ActiveRecordCacheInterface $cacheModel)
    {
        $this->cacheModel = $cacheModel;
    }

    /**
     * Метод возвращает значение свойство кеша.
     *
     * @return ActiveRecordCacheInterface
     */
    protected function getCacheModel()
    {
        if (null === $this->cacheModel) {
            throw new InvalidValueException('Cache has empty value.');
        }
        return $this->cacheModel;
    }

    /**
     * Метод задает значение свойству построителя запросов.
     *
     * @param LanguageQuery $query Новое значение.
     *
     * @return void
     */
    public function setQuery(LanguageQuery $query)
    {
        $this->query = $query;
    }

    /**
     * Метод возвращает значение свойство построителя запросов.
     *
     * @return LanguageQuery
     */
    protected function getQuery()
    {
        if (empty($this->query)) {
            throw new InvalidValueException('Query has empty value.');
        }
        return $this->query;
    }

    /**
     * Метод добавляет выборку по флагу основного языка.
     *
     * @param boolean $isDefault значение флага.
     *
     * @return LanguageGetInterface
     */
    public function byDefault($isDefault = true)
    {
        $this->getQuery()->byDefault($isDefault);
        return $this;
    }

    /**
     * Метод добавляет выборку по коду языка.
     *
     * @param integer $code Код языка.
     *
     * @return LanguageGetInterface
     */
    public function byCode($code)
    {
        $this->getQuery()->byCode($code);
        return $this;
    }

    /**
     * Метод добавляет выборку по урлу языка.
     *
     * @param string $url Урл языка, который хотим получить.
     *
     * @return LanguageGetInterface
     */
    public function byUrl($url)
    {
        $this->getQuery()->byUrl($url);
        return $this;
    }

    /**
     * Метод добавляет выборку по идентификатору языка.
     *
     * @param integer $id Идентификатор языка.
     *
     * @return LanguageGetInterface
     */
    public function byId($id)
    {
        $this->getQuery()->byId($id);
        return $this;
    }

    /**
     * Метод добавляет выборку по флагу активности языка.
     *
     * @param boolean $isActive Флаг активности языка.
     *
     * @return LanguageGetInterface
     */
    public function byActive($isActive = true)
    {
        $this->getQuery()->byActive($isActive);
        return $this;
    }

    /**
     * Метод добавляет сортировку по выборке.
     *
     * @return LanguageGetInterface
     */
    public function sort()
    {
        $this->getQuery()->sort();
        return $this;
    }

    /**
     * Метод получения одного языка.
     *
     * @return LanguageInterface
     *
     * @throws Exception Генерирует в случает неправильной рабоыт кеша.
     */
    public function one()
    {
        if (false !== $modelList = $this->getCacheModel()->getFromCache($this->getQuery())) {
            if (! empty($modelList)) {
                return array_pop($modelList);
            }
            return null;
        }

        $language = $this->getQuery()->one();
        $language = $this->toModel($language);
        $this->getCacheModel()->setToCache($this->getQuery(), [$language]);
        return $language;
    }

    /**
     * Метод получения списка языков.
     *
     * @return LanguageInterface[]
     *
     * @throws Exception Генерирует в случает неправильной рабоыт кеша.
     */
    public function all()
    {
        if (false !== $languageList = $this->getCacheModel()->getFromCache($this->getQuery(), true)) {
            return $languageList;
        }

        $languageList = $this->getQuery()->all();
        $languageList = $this->toModelList($languageList);
        $this->getCacheModel()->setToCache($this->getQuery(), $languageList, true);
        return $languageList;
    }

    /**
     * Метод преобразует модель записи в модель.
     *
     * @param mixed $languageAR Запись из БД.
     *
     * @return null|LanguageInterface
     */
    protected function toModel($languageAR)
    {
        if (empty($languageAR)) {
            return null;
        }
        $result = Yii::$app->i18n->getModelFactory()->getLanguageModel();
        $result->setAttributes($languageAR->getAttributes());
        $result->setIsNewRecord($languageAR->getIsNewRecord());
        return $result;
    }

    /**
     * Метод преобразует список записей в список моделей.
     *
     * @param array $languageARList Записи из БД.
     *
     * @return LanguageInterface[]
     */
    protected function toModelList(array $languageARList)
    {
        $result = [];
        foreach ($languageARList as $index => $languageAR) {
            $result[$index] = $this->toModel($languageAR);
        }
        return $result;
    }
}
