<?php

namespace Userstory\I18n\factories;

use InvalidArgumentException;
use Userstory\ComponentBase\interfaces\ActiveRecordCacheInterface;
use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\I18n\interfaces\ClearCacheInterface;
use Userstory\I18n\interfaces\I18nFactoryInterface;
use Userstory\I18n\interfaces\LanguageDeleteInterface;
use Userstory\I18n\interfaces\LanguageGetInterface;
use Userstory\I18n\interfaces\LanguageInterface;
use Userstory\I18n\interfaces\LanguageSaveInterface;
use Userstory\I18n\interfaces\MessageExportInterface;
use Userstory\I18n\interfaces\MessageGetInterface;
use Userstory\I18n\interfaces\MessageInterface;
use Userstory\I18n\interfaces\MessageSaveInterface;
use Userstory\I18n\interfaces\SourceMessageGetInterface;
use Userstory\I18n\queries\LanguageQuery;
use Userstory\I18n\queries\MessageQuery;
use Userstory\I18n\queries\SourceMessageQuery;
use yii\base\InvalidConfigException;

/**
 * Фабрика I18nFactory Реализует получение моделей языкового модуля.
 *
 * @package Userstory\I18n\factories
 */
class I18nFactory extends ModelsFactory implements I18nFactoryInterface
{
    const LANGUAGE_MODEL            = 'languageModel';
    const LANGUAGE_QUERY            = 'languageQuery';
    const LANGUAGE_GET_OPERATION    = 'languageGetOperation';
    const LANGUAGE_SAVE_OPERATION   = 'languageSaveOperation';
    const LANGUAGE_DELETE_OPERATION = 'languageDeleteOperation';
    const LANGUAGE_CACHE_MODEL      = 'languageCacheModel';

    const MESSAGE_MODEL          = 'messageModel';
    const MESSAGE_QUERY          = 'messageQuery';
    const MESSAGE_GET_OPERATION  = 'messageGetOperation';
    const MESSAGE_SAVE_OPERATION = 'messageSaveOperation';
    const MESSAGE_CACHE_MODEL    = 'messageCacheModel';
    const MESSAGE_CSV_EXPORTER   = 'messageCSVExporter';
    const MESSAGE_XLSX_EXPORTER  = 'messageXLSXExporter';

    const SOURCE_MESSAGE_QUERY         = 'sourceMessageQuery';
    const SOURCE_MESSAGE_GET_OPERATION = 'sourceMessageGetOperation';

    const HYDRATOR_MODEL        = 'hydratorModel';
    const CLEAR_CACHE_OPERATION = 'clearCacheOperation';

    /**
     * Метод возвращает модель построителя запросов для языков.
     *
     * @return LanguageInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getLanguageModel()
    {
        $result = $this->getModelInstance(self::LANGUAGE_MODEL, [], false);
        if (! $result instanceof LanguageInterface) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . LanguageInterface::class);
        }
        return $result;
    }

    /**
     * Метод возвращает модель построителя запросов для языков.
     *
     * @return LanguageQuery
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    protected function getLanguageQuery()
    {
        $result = $this->getModelInstance(self::LANGUAGE_QUERY, [], false);
        if (! $result instanceof LanguageQuery) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . LanguageQuery::class);
        }
        return $result;
    }

    /**
     * Метод возвращает модель кеша для языков.
     *
     * @return ActiveRecordCacheInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    protected function getLanguageCache()
    {
        $result = $this->getModelInstance(self::LANGUAGE_CACHE_MODEL, []);
        if (! $result instanceof ActiveRecordCacheInterface) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . ActiveRecordCacheInterface::class);
        }
        $result->setHydrator($this->getHydratorModel());
        $result->setModelInstance($this->getLanguageModel());
        return $result;
    }

    /**
     * Метод возвращает модель геттера языков.
     *
     * @return LanguageGetInterface.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getLanguageGetter()
    {
        $result = $this->getModelInstance(self::LANGUAGE_GET_OPERATION, []);
        if (! $result instanceof LanguageGetInterface) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . LanguageGetInterface::class);
        }
        $result->setQuery($this->getLanguageQuery());
        $result->setCacheModel($this->getLanguageCache());
        return $result;
    }

    /**
     * Метод возвращает модель сохранения языков.
     *
     * @return LanguageSaveInterface.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getLanguageSaver()
    {
        $result = $this->getModelInstance(self::LANGUAGE_SAVE_OPERATION, []);
        if (! $result instanceof LanguageSaveInterface) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . LanguageSaveInterface::class);
        }
        $result->setQuery($this->getLanguageQuery());
        $result->setCacheModel($this->getLanguageCache());
        return $result;
    }

    /**
     * Метод возвращает модель удаления языков.
     *
     * @return LanguageDeleteInterface.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getLanguageRemover()
    {
        $result = $this->getModelInstance(self::LANGUAGE_DELETE_OPERATION, []);
        if (! $result instanceof LanguageDeleteInterface) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . LanguageDeleteInterface::class);
        }
        $result->setQuery($this->getLanguageQuery());
        $result->setCacheModel($this->getLanguageCache());
        return $result;
    }

    /**
     * Метод возвращает модель переводов.
     *
     * @return MessageInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getMessageModel()
    {
        $result = $this->getModelInstance(self::MESSAGE_MODEL, [], false);
        if (! $result instanceof MessageInterface) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . MessageInterface::class);
        }
        return $result;
    }

    /**
     * Метод возвращает модель построителя запросов для переводов.
     *
     * @return MessageQuery
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    protected function getMessageQuery()
    {
        $result = $this->getModelInstance(self::MESSAGE_QUERY, [], false);
        if (! $result instanceof MessageQuery) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . MessageQuery::class);
        }
        return $result;
    }

    /**
     * Метод возвращает модель кеша для переводов.
     *
     * @return ActiveRecordCacheInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    protected function getMessageCache()
    {
        $result = $this->getModelInstance(self::MESSAGE_CACHE_MODEL, []);
        if (! $result instanceof ActiveRecordCacheInterface) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . ActiveRecordCacheInterface::class);
        }
        $result->setHydrator($this->getHydratorModel());
        $result->setModelInstance($this->getMessageModel());
        return $result;
    }

    /**
     * Метод возвращает модель геттера переводов.
     *
     * @return MessageGetInterface.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getMessageGetter()
    {
        $result = $this->getModelInstance(self::MESSAGE_GET_OPERATION, []);
        if (! $result instanceof MessageGetInterface) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . MessageGetInterface::class);
        }
        $result->setQuery($this->getMessageQuery());
        $result->setCacheModel($this->getMessageCache());
        return $result;
    }

    /**
     * Метод возвращает модель сохранения языков.
     *
     * @return MessageSaveInterface.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getMessageSaver()
    {
        $result = $this->getModelInstance(self::MESSAGE_SAVE_OPERATION, []);
        if (! $result instanceof MessageSaveInterface) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . MessageSaveInterface::class);
        }
        $result->setQuery($this->getMessageQuery());
        $result->setCacheModel($this->getMessageCache());
        return $result;
    }

    /**
     * Метод возвращает модель построителя запросов для ресурса переводов.
     *
     * @return SourceMessageQuery
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    protected function getSourceMessageQuery()
    {
        $result = $this->getModelInstance(self::SOURCE_MESSAGE_QUERY, [], false);
        if (! $result instanceof SourceMessageQuery) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . SourceMessageQuery::class);
        }
        return $result;
    }

    /**
     * Метод возвращает модель геттера ресурса переводов.
     *
     * @return SourceMessageGetInterface.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getSourceMessageGetter()
    {
        $result = $this->getModelInstance(self::SOURCE_MESSAGE_GET_OPERATION, []);
        if (! $result instanceof SourceMessageGetInterface) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . SourceMessageGetInterface::class);
        }
        $result->setQuery($this->getSourceMessageQuery());
        return $result;
    }

    /**
     * Метод возвращает модель гидратора.
     *
     * @return HydratorInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    protected function getHydratorModel()
    {
        $result = $this->getModelInstance(self::HYDRATOR_MODEL, []);
        if (! $result instanceof HydratorInterface) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . HydratorInterface::class);
        }
        return $result;
    }

    /**
     * Метод возвращает объект очистки кеша для компонента мультиязычности.
     *
     * @return ClearCacheInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getClearCacheOperation()
    {
        $result = $this->getModelInstance(self::CLEAR_CACHE_OPERATION, []);
        if (! $result instanceof ClearCacheInterface) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . ClearCacheInterface::class);
        }
        $result->setCacheModel($this->getLanguageCache());
        $result->setCacheModel($this->getMessageCache());
        return $result;
    }

    /**
     * Метод возвращает модель экспорта.
     *
     * @param string $exporterType Тип экспортера.
     *
     * @return MessageExportInterface.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getMessageExporter($exporterType = 'xlsx')
    {
        if ('xlsx' === $exporterType) {
            $result = $this->getModelInstance(self::MESSAGE_XLSX_EXPORTER, []);
        } elseif ('csv' === $exporterType) {
            $result = $this->getModelInstance(self::MESSAGE_CSV_EXPORTER, []);
        } else {
            throw new InvalidArgumentException();
        }
        if (! $result instanceof MessageExportInterface) {
            throw new InvalidConfigException('Class of the returned object must implement the ' . MessageExportInterface::class);
        }
        return $result;
    }
}
