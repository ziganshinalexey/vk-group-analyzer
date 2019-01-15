<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\filters\user;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\Yii2VkApi\interfaces\user\filters\BaseFilterInterface;

/**
 * Класс реализует методы применения фильтра к операции.
 */
class BaseFilter extends Model implements BaseFilterInterface
{
    /**
     * Свойство хранит атрибут "Факультет" сущности "ВК пользователь".
     *
     * @var string|null
     */
    protected $facultyName;

    /**
     * Свойство хранит атрибут "Имя" сущности "ВК пользователь".
     *
     * @var string|null
     */
    protected $firstName;

    /**
     * Свойство хранит атрибут "Идентификатор" сущности "ВК пользователь".
     *
     * @var int|null
     */
    protected $id;

    /**
     * Свойство хранит атрибут "Фамилия" сущности "ВК пользователь".
     *
     * @var string|null
     */
    protected $lastName;

    /**
     * Свойство хранит атрибут "Факультет" сущности "ВК пользователь".
     *
     * @var string|null
     */
    protected $photo;

    /**
     * Свойство хранит атрибут "Университет" сущности "ВК пользователь".
     *
     * @var string|null
     */
    protected $universityName;

    /**
     * Метод возвращает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @return string
     */
    public function getFacultyName()
    {
        return $this->facultyName;
    }

    /**
     * Метод возвращает атрибут "Имя" сущности "ВК пользователь".
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Метод возвращает атрибут "Идентификатор" сущности "ВК пользователь".
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Метод возвращает атрибут "Фамилия" сущности "ВК пользователь".
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Метод возвращает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Метод возвращает атрибут "Университет" сущности "ВК пользователь".
     *
     * @return string
     */
    public function getUniversityName()
    {
        return $this->universityName;
    }
}
