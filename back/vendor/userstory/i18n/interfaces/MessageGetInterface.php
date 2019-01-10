<?php

namespace Userstory\I18n\interfaces;

use Userstory\ComponentBase\interfaces\ActiveRecordCacheInterface;
use Userstory\I18n\queries\MessageQuery;

/**
 * Интерфейс LanguageGetInterface Объявляет реализацию операций получения сообщений.
 *
 * @package Userstory\I18n\interfaces
 */
interface MessageGetInterface
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
     * @param MessageQuery $query Новое значение.
     *
     * @return void
     */
    public function setQuery(MessageQuery $query);

    /**
     * Метод добавляет выборку по идентификатору языка.
     *
     * @param integer $languageId Идентификатор языка.
     *
     * @return MessageGetInterface
     */
    public function byLanguageId($languageId);

    /**
     * Метод добавляет выборку по идентификатору перевода.
     *
     * @param integer $messageId Идентификатор перевода.
     *
     * @return MessageGetInterface
     */
    public function byMessageId($messageId);

    /**
     * Метод добавляет выборку категории перевода.
     *
     * @param string $category Категория перевода.
     *
     * @return MessageGetInterface
     */
    public function byCategory($category);

    /**
     * Метод получения одного перевода.
     *
     * @return MessageInterface
     */
    public function one();

    /**
     * Метод получения списка переводов.
     *
     * @return MessageInterface[]
     */
    public function all();
}
