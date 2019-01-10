<?php

namespace Userstory\I18n\interfaces;

use Userstory\I18n\queries\SourceMessageQuery;

/**
 * Интерфейс SourceMessageGetInterface Объявляет реализацию операций получения ресурса переводов.
 *
 * @package Userstory\I18n\interfaces
 */
interface SourceMessageGetInterface
{
    /**
     * Метод задает значение свойству построителя запросов.
     *
     * @param SourceMessageQuery $query Новое значение.
     *
     * @return void
     */
    public function setQuery(SourceMessageQuery $query);

    /**
     * Метод возвращает список всех ресурсов переводов.
     *
     * @return SourceMessageInterface[]
     */
    public function getAll();

    /**
     * Метод возвращает список ресурсов переводов по их категории и алиасу.
     *
     * @param string $category Категория ресурса.
     * @param string $message  Алиас ресурса.
     *
     * @return SourceMessageInterface
     */
    public function getByCategoryAndAlias($category, $message);

    /**
     * Возвращает ресурс перевода по его идентификатору.
     *
     * @param integer $id Идентификатор ресурса перевода.
     *
     * @return SourceMessageInterface
     */
    public function getById($id);

    /**
     * Метод поиска всех переводов.
     *
     * @param string  $needle     Фильтр поиска по переводам.
     * @param integer $languageId Индификатор языка.
     *
     * @return SourceMessageInterface[]
     */
    public function getSearchModelList($needle, $languageId = null);
}
