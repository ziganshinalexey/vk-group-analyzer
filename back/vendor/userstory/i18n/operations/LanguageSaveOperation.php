<?php

namespace Userstory\I18n\operations;

use Userstory\ComponentBase\interfaces\ActiveRecordCacheInterface;
use Userstory\I18n\entities\LanguageActiveRecord;
use Userstory\I18n\interfaces\LanguageInterface;
use Userstory\I18n\interfaces\LanguageSaveInterface;
use Userstory\I18n\queries\LanguageQuery;
use yii;
use yii\base\InvalidValueException;

/**
 * Класс LanguageSaveOperations реализует методы сохранения языков.
 *
 * @package Userstory\I18n\operations
 */
class LanguageSaveOperation implements LanguageSaveInterface
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
     * Метод сохранения языка из модели данных.
     *
     * @param LanguageInterface $dataModel Модель данных языка.
     *
     * @return boolean
     */
    public function saveByDataModel(LanguageInterface $dataModel)
    {
        if ($dataModel->getIsNewRecord()) {
            $languageModel = Yii::createObject(LanguageActiveRecord::class);
        } else {
            $languageModel = $this->getQuery()->byId($dataModel->getId())->one();
        }

        $languageModel->setAttributes($dataModel->getAttributes());

        if (! $this->saveByEntityModel($languageModel)) {
            $dataModel->addErrors($languageModel->errors);
            return false;
        }
        return true;
    }

    /**
     * Метод сохранения языка из модели данных.
     *
     * @param LanguageActiveRecord $entityModel Модель сущности языка.
     *
     * @return boolean
     */
    public function saveByEntityModel(LanguageActiveRecord $entityModel)
    {
        $this->getCacheModel()->clearCacheByModel($entityModel);
        return $entityModel->save();
    }
}
