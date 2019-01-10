<?php

namespace Userstory\I18n\operations;

use Userstory\ComponentBase\interfaces\ActiveRecordCacheInterface;
use Userstory\I18n\entities\MessageActiveRecord;
use Userstory\I18n\interfaces\MessageInterface;
use Userstory\I18n\interfaces\MessageSaveInterface;
use Userstory\I18n\queries\MessageQuery;
use yii;
use yii\base\InvalidValueException;

/**
 * Класс MessageSaveOperations реализует методы сохранения переводов.
 *
 * @package Userstory\I18n\operations
 */
class MessageSaveOperation implements MessageSaveInterface
{
    /**
     * Свойство хранит объект построителя запросов.
     *
     * @var MessageQuery|null
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
     * @param MessageQuery $query Новое значение.
     *
     * @return void
     */
    public function setQuery(MessageQuery $query)
    {
        $this->query = $query;
    }

    /**
     * Метод возвращает значение свойство построителя запросов.
     *
     * @return MessageQuery
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
     * @param MessageInterface $dataModel  Модель данных перевода.
     * @param boolean          $clearCache Флаг чистки кеша.
     *
     * @return boolean
     */
    public function saveByDataModel(MessageInterface $dataModel, $clearCache = true)
    {
        if ($dataModel->getIsNewRecord()) {
            $entityModel = Yii::createObject(MessageActiveRecord::class);
        } else {
            $entityModel = $this->getQuery()->byId($dataModel->getId())->byLanguageId($dataModel->getLanguageId())->one();
        }
        $entityModel->setAttributes($dataModel->getAttributes(), false);

        return $this->saveByEntityModel($entityModel, $clearCache);
    }

    /**
     * Метод сохранения языка из модели данных.
     *
     * @param MessageActiveRecord $entityModel Модель сущности языка.
     * @param boolean             $clearCache  Флаг чистки кеша.
     *
     * @return boolean
     */
    public function saveByEntityModel(MessageActiveRecord $entityModel, $clearCache = true)
    {
        if ($clearCache) {
            $this->getCacheModel()->clearCacheByModel($entityModel);
        }
        return $entityModel->save(false);
    }
}
