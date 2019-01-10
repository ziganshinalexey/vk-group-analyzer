<?php

namespace Userstory\I18n\interfaces;

use Userstory\ComponentBase\interfaces\ActiveRecordCacheInterface;
use Userstory\I18n\queries\LanguageQuery;

/**
 * Интерфейс LanguageDeleteInterface Объявляет реализацию операций удаления языков.
 *
 * @package Userstory\I18n\interfaces
 */
interface LanguageDeleteInterface
{
    /**
     * Метод задает значение свойству построителя запросов.
     *
     * @param LanguageQuery $query Новое значение.
     *
     * @return void
     */
    public function setQuery(LanguageQuery $query);

    /**
     * Метод задает значение свойству кеша.
     *
     * @param ActiveRecordCacheInterface $cacheModel Новое значение.
     *
     * @return void
     */
    public function setCacheModel(ActiveRecordCacheInterface $cacheModel);

    /**
     * Метод удаления языка по его идентификатору.
     *
     * @param integer $id Идентификатор языка.
     *
     * @return boolean
     */
    public function deleteById($id);
}
