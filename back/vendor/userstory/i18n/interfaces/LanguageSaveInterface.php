<?php

namespace Userstory\I18n\interfaces;

use Userstory\ComponentBase\interfaces\ActiveRecordCacheInterface;
use Userstory\I18n\entities\LanguageActiveRecord;

/**
 * Интерфейс LanguageSaveInterface Объявляет реализацию операций сохранения языков.
 *
 * @package Userstory\I18n\interfaces
 */
interface LanguageSaveInterface
{
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
     * @param LanguageInterface $dataModel Модель данных языка.
     *
     * @return boolean
     */
    public function saveByDataModel(LanguageInterface $dataModel);

    /**
     * Метод сохранения языка из модели данных.
     *
     * @param LanguageActiveRecord $entityModel Модель сущности языка.
     *
     * @return boolean
     */
    public function saveByEntityModel(LanguageActiveRecord $entityModel);
}
