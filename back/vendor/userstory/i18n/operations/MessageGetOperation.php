<?php

namespace Userstory\I18n\operations;

use Userstory\ComponentBase\interfaces\ActiveRecordCacheInterface;
use Userstory\I18n\interfaces\MessageGetInterface;
use Userstory\I18n\interfaces\MessageInterface;
use Userstory\I18n\models\SourceMessageModel;
use Userstory\I18n\queries\MessageQuery;
use yii;
use yii\base\InvalidValueException;

/**
 * Класс MessageGetOperations реализует методы получения сообщений.
 *
 * @package Userstory\I18n\operations
 */
class MessageGetOperation implements MessageGetInterface
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
     * @var MessageQuery|null
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
     * Метод добавляет выборку по идентификатору языка.
     *
     * @param integer $languageId Идентификатор языка.
     *
     * @return MessageGetInterface
     */
    public function byLanguageId($languageId)
    {
        $this->getQuery()->byLanguageId($languageId);
        return $this;
    }

    /**
     * Метод добавляет выборку по идентификатору перевода.
     *
     * @param integer $messageId Идентификатор перевода.
     *
     * @return MessageGetInterface
     */
    public function byMessageId($messageId)
    {
        $this->getQuery()->byId($messageId);
        return $this;
    }

    /**
     * Метод добавляет выборку категории перевода.
     *
     * @param string $category Категория перевода.
     *
     * @return MessageGetInterface
     */
    public function byCategory($category)
    {
        $this->getQuery()->byCategory($category);
        return $this;
    }

    /**
     * Метод получения одного перевода.
     *
     * @return MessageInterface
     */
    public function one()
    {
        if (false !== $modelList = $this->getCacheModel()->getFromCache($this->getQuery())) {
            if (! empty($modelList)) {
                return array_pop($modelList);
            }
            return null;
        }
        $message = $this->getQuery()->one();
        $message = $this->toModel($message);
        $this->getCacheModel()->setToCache($this->getQuery(), [$message]);
        return $message;
    }

    /**
     * Метод получения списка переводов.
     *
     * @return MessageInterface[]
     */
    public function all()
    {
        if (false !== $messageList = $this->getCacheModel()->getFromCache($this->getQuery(), true)) {
            return $messageList;
        }

        $messageList = $this->getQuery()->all();
        $messageList = $this->toModelList($messageList);
        $this->getCacheModel()->setToCache($this->getQuery(), $messageList, true);
        return $messageList;
    }

    /**
     * Метод преобразует модель записи в модель.
     *
     * @param mixed $languageAR Запись из БД.
     *
     * @return null|MessageInterface
     */
    protected function toModel($languageAR)
    {
        if (empty($languageAR)) {
            return null;
        }

        $result = Yii::$app->i18n->getModelFactory()->getMessageModel();
        $result->setAttributes($languageAR->getAttributes());
        $result->setIsNewRecord($languageAR->getIsNewRecord());
        $sourceMessageModel = Yii::createObject(SourceMessageModel::class);
        $sourceMessageModel->setAttributes($languageAR->sourceMessage->getAttributes());
        $result->setSourceMessage($sourceMessageModel);
        return $result;
    }

    /**
     * Метод преобразует список записей в список моделей.
     *
     * @param array $languageARList Записи из БД.
     *
     * @return MessageInterface[]
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
