<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\filters\keyword;

use yii\base\Model;
use Ziganshinalexey\Keyword\interfaces\keyword\filters\BaseFilterInterface;

/**
 * Класс реализует методы применения фильтра к операции.
 */
class BaseFilter extends Model implements BaseFilterInterface
{
    /**
     * Свойство хранит атрибут "Количество совпадений" сущности "Ключевое фраза".
     *
     * @var int|null
     */
    protected $coincidenceCount;

    /**
     * Свойство хранит атрибут "Идентификатор" сущности "Ключевое фраза".
     *
     * @var int|null
     */
    protected $id;

    /**
     * Свойство хранит атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @var int|null
     */
    protected $personTypeId;

    /**
     * Свойство хранит атрибут "Коэффициент" сущности "Ключевое фраза".
     *
     * @var int|null
     */
    protected $ratio;

    /**
     * Свойство хранит атрибут "Название" сущности "Ключевое фраза".
     *
     * @var string|null
     */
    protected $text;

    /**
     * Метод возвращает атрибут "Количество совпадений" сущности "Ключевое фраза".
     *
     * @return int
     */
    public function getCoincidenceCount()
    {
        return $this->coincidenceCount;
    }

    /**
     * Метод возвращает атрибут "Идентификатор" сущности "Ключевое фраза".
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Метод возвращает атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @return int
     */
    public function getPersonTypeId()
    {
        return $this->personTypeId;
    }

    /**
     * Метод возвращает атрибут "Коэффициент" сущности "Ключевое фраза".
     *
     * @return int
     */
    public function getRatio()
    {
        return $this->ratio;
    }

    /**
     * Метод возвращает атрибут "Название" сущности "Ключевое фраза".
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
