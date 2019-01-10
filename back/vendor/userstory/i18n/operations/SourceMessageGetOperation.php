<?php

namespace Userstory\I18n\operations;

use Userstory\I18n\interfaces\SourceMessageGetInterface;
use Userstory\I18n\interfaces\SourceMessageInterface;
use Userstory\I18n\queries\SourceMessageQuery;
use yii\base\InvalidValueException;

/**
 * Класс MessageGetOperations реализует методы получения ресурса переводов.
 *
 * @package Userstory\I18n\operations
 */
class SourceMessageGetOperation implements SourceMessageGetInterface
{
    /**
     * Свойство хранит объект построителя запросов.
     *
     * @var SourceMessageQuery|null
     */
    protected $query;

    /**
     * Метод задает значение свойству построителя запросов.
     *
     * @param SourceMessageQuery $query Новое значение.
     *
     * @return void
     */
    public function setQuery(SourceMessageQuery $query)
    {
        $this->query = $query;
    }

    /**
     * Метод возвращает значение свойство построителя запросов.
     *
     * @return SourceMessageQuery
     */
    protected function getQuery()
    {
        if (empty($this->query)) {
            throw new InvalidValueException('Query has empty value.');
        }
        return $this->query;
    }

    /**
     * Метод возвращает список всех ресурсов переводов.
     *
     * @return SourceMessageInterface[]
     */
    public function getAll()
    {
        return $this->getQuery()->all();
    }

    /**
     * Метод возвращает список ресурсов переводов по их категории и алиасу.
     *
     * @param string $category Категория ресурса.
     * @param string $message  Алиас ресурса.
     *
     * @return SourceMessageInterface
     */
    public function getByCategoryAndAlias($category, $message)
    {
        return $this->getQuery()->byMessage($message)->byCategory($category)->one();
    }

    /**
     * Возвращает ресурс перевода по его идентификатору.
     *
     * @param integer $id Идентификатор ресурса перевода.
     *
     * @return SourceMessageInterface
     */
    public function getById($id)
    {
        return $this->getQuery()->byId($id)->one();
    }

    /**
     * Метод поиска всех переводов.
     *
     * @param string  $needle     Фильтр поиска по переводам.
     * @param integer $languageId Индификатор языка.
     *
     * @return SourceMessageInterface[]
     */
    public function getSearchModelList($needle, $languageId = null)
    {
        if (null === $languageId) {
            return $this->getQuery()->search($needle)->all();
        } else {
            return $this->getQuery()->search($needle)->byLaguageId($languageId)->all();
        }
    }
}
