<?php

namespace Userstory\I18n\interfaces;

use Userstory\ComponentBase\interfaces\ActiveRecordCacheInterface;
use Userstory\I18n\entities\MessageActiveRecord;
use Userstory\I18n\queries\MessageQuery;

/**
 * Интерфейс MessageSaveInterface Объявляет реализацию операций сохранения преводов.
 *
 * @package Userstory\I18n\interfaces
 */
interface MessageSaveInterface
{
    /**
     * Метод задает значение свойству построителя запросов.
     *
     * @param MessageQuery $query Новое значение.
     *
     * @return void
     */
    public function setQuery(MessageQuery $query);

    /**
     * Метод задает значение свойству кеша.
     *
     * @param ActiveRecordCacheInterface $cacheModel Новое значение.
     *
     * @return void
     */
    public function setCacheModel(ActiveRecordCacheInterface $cacheModel);

    /**
     * Метод сохранения языка из модели данных.
     *
     * @param MessageInterface $dataModel  Модель данных перевода.
     * @param boolean          $clearCache Флаг чистки кеша.
     *
     * @return boolean
     */
    public function saveByDataModel(MessageInterface $dataModel, $clearCache = true);

    /**
     * Метод сохранения языка из модели данных.
     *
     * @param MessageActiveRecord $entityModel Модель сущности языка.
     * @param boolean             $clearCache  Флаг чистки кеша.
     *
     * @return boolean
     */
    public function saveByEntityModel(MessageActiveRecord $entityModel, $clearCache = true);
}
