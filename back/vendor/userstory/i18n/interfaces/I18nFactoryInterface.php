<?php

namespace Userstory\I18n\interfaces;

use yii\base\InvalidConfigException;

/**
 * Интерфейс I18nFactoryInterface Объявляет реализацию фабрики моделей пакета.
 *
 * @package Userstory\I18n\interfaces
 */
interface I18nFactoryInterface
{
    /**
     * Метод возвращает модель построителя запросов для языков.
     *
     * @return LanguageInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getLanguageModel();

    /**
     * Метод возвращает модель геттера языков.
     *
     * @return LanguageGetInterface.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getLanguageGetter();

    /**
     * Метод возвращает модель сохранения языков.
     *
     * @return LanguageSaveInterface.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getLanguageSaver();

    /**
     * Метод возвращает модель удаления языков.
     *
     * @return LanguageDeleteInterface.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getLanguageRemover();

    /**
     * Метод возвращает модель переводов.
     *
     * @return MessageInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getMessageModel();

    /**
     * Метод возвращает модель геттера переводов.
     *
     * @return MessageGetInterface.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getMessageGetter();

    /**
     * Метод возвращает модель сохранения языков.
     *
     * @return MessageSaveInterface.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getMessageSaver();

    /**
     * Метод возвращает модель геттера ресурса переводов.
     *
     * @return SourceMessageGetInterface.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getSourceMessageGetter();

    /**
     * Метод возвращает объект очистки кеша для компонента мультиязычности.
     *
     * @return ClearCacheInterface
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getClearCacheOperation();

    /**
     * Метод возвращает модель экспорта.
     *
     * @param string $exporterType Тип экспортера.
     *
     * @return MessageExportInterface.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     */
    public function getMessageExporter($exporterType = 'xlsx');
}
