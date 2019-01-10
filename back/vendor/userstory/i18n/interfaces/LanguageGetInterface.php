<?php

namespace Userstory\I18n\interfaces;

use Userstory\ComponentBase\interfaces\ActiveRecordCacheInterface;
use Userstory\I18n\queries\LanguageQuery;

/**
 * Интерфейс LanguageGetInterface Объявляет реализацию операций получения языков.
 *
 * @package Userstory\I18n\interfaces
 */
interface LanguageGetInterface
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
     * Метод задает значение свойству построителя запросов.
     *
     * @param LanguageQuery $query Новое значение.
     *
     * @return void
     */
    public function setQuery(LanguageQuery $query);

    /**
     * Метод добавляет выборку по флагу основного языка.
     *
     * @param boolean $isDefault значение флага.
     *
     * @return LanguageGetInterface
     */
    public function byDefault($isDefault = true);

    /**
     * Метод добавляет выборку по коду языка.
     *
     * @param integer $code Код языка.
     *
     * @return LanguageGetInterface
     */
    public function byCode($code);

    /**
     * Метод добавляет выборку по урлу языка.
     *
     * @param string $url Урл языка, который хотим получить.
     *
     * @return LanguageGetInterface
     */
    public function byUrl($url);

    /**
     * Метод добавляет выборку по идентификатору языка.
     *
     * @param integer $id Идентификатор языка.
     *
     * @return LanguageGetInterface
     */
    public function byId($id);

    /**
     * Метод добавляет выборку по флагу активности языка.
     *
     * @param boolean $isActive Флаг активности языка.
     *
     * @return LanguageGetInterface
     */
    public function byActive($isActive = true);

    /**
     * Метод добавляет сортировку по выборке.
     *
     * @return LanguageGetInterface
     */
    public function sort();

    /**
     * Метод получения одного языка.
     *
     * @return LanguageInterface
     */
    public function one();

    /**
     * Метод получения списка языков.
     *
     * @return LanguageInterface[]
     */
    public function all();
}
