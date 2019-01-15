<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\filters\group;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\Yii2VkApi\interfaces\group\filters\BaseFilterInterface;

/**
 * Класс реализует методы применения фильтра к операции.
 */
class BaseFilter extends Model implements BaseFilterInterface
{
    /**
     * Свойство хранит атрибут "Название" сущности "ВК группа".
     *
     * @var string|null
     */
    protected $activity;

    /**
     * Свойство хранит атрибут "Название" сущности "ВК группа".
     *
     * @var string|null
     */
    protected $description;

    /**
     * Свойство хранит атрибут "Идентификатор" сущности "ВК группа".
     *
     * @var int|null
     */
    protected $id;

    /**
     * Свойство хранит атрибут "Название" сущности "ВК группа".
     *
     * @var string|null
     */
    protected $name;

    /**
     * Метод возвращает атрибут "Название" сущности "ВК группа".
     *
     * @return string
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Метод возвращает атрибут "Название" сущности "ВК группа".
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Метод возвращает атрибут "Идентификатор" сущности "ВК группа".
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Метод возвращает атрибут "Название" сущности "ВК группа".
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
