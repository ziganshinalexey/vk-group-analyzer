<?php

namespace Userstory\I18n\operations;

use Userstory\ComponentBase\interfaces\ActiveRecordCacheInterface;
use Userstory\I18n\interfaces\LanguageDeleteInterface;
use Userstory\I18n\queries\LanguageQuery;
use yii\base\InvalidValueException;
use yii\web\NotFoundHttpException;

/**
 * Класс LanguageDeleteOperation реализует методы сохранения языков.
 *
 * @package Userstory\I18n\operations
 */
class LanguageDeleteOperation implements LanguageDeleteInterface
{
    /**
     * Свойство хранит объект построителя запросов.
     *
     * @var LanguageQuery|null
     */
    protected $query;

    /**
     * Свойство хранит объект кеширования.
     *
     * @var ActiveRecordCacheInterface|null
     */
    protected $cacheModel;

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
     * Метод удаления языка по его идентификатору.
     *
     * @param integer $id Идентификатор языка.
     *
     * @return boolean
     *
     * @throws NotFoundHttpException, Генерирует в случае отсутствия языка.
     */
    public function deleteById($id)
    {
        $languageModel = $this->getQuery()->byId($id)->one();
        if (empty($languageModel)) {
            throw new NotFoundHttpException();
        }
        if ($languageModel->isDefault) {
            return false;
        }
        if ($languageModel->delete()) {
            $this->getCacheModel()->clearCacheByModel($languageModel);
        }
        return true;
    }
}
