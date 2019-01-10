<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\filters\personType;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\PersonType\interfaces\personType\filters\BaseFilterInterface;

/**
 * Класс реализует методы применения фильтра к операции.
 */
class BaseFilter extends Model implements BaseFilterInterface
{
    /**
     * Свойство хранит атрибут "Идентификатор" сущности "Тип личности".
     *
     * @var int|null
     */
    protected $id;

    /**
     * Свойство хранит атрибут "Название" сущности "Тип личности".
     *
     * @var string|null
     */
    protected $name;

    /**
     * Метод возвращает атрибут "Идентификатор" сущности "Тип личности".
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Метод возвращает атрибут "Название" сущности "Тип личности".
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
