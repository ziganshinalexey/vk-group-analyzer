<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\dataTransferObjects\user;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;

/**
 * Реализует логику DTO "ВК пользователь" для хранения и обмена данными с другими компонентами системы.
 */
class User extends Model implements UserInterface
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
     * Метод копирования объекта DTO.
     *
     * @return UserInterface
     */
    public function copy(): UserInterface
    {
        return new static();
    }

    /**
     * Метод возвращает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @return string|null
     */
    public function getFacultyName(): ?string
    {
        return null === $this->facultyName ? null : (string)$this->facultyName;
    }

    /**
     * Метод возвращает атрибут "Имя" сущности "ВК пользователь".
     *
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return null === $this->firstName ? null : (string)$this->firstName;
    }

    /**
     * Метод возвращает атрибут "Идентификатор" сущности "ВК пользователь".
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return null === $this->id ? null : (int)$this->id;
    }

    /**
     * Метод возвращает атрибут "Фамилия" сущности "ВК пользователь".
     *
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return null === $this->lastName ? null : (string)$this->lastName;
    }

    /**
     * Метод возвращает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @return string|null
     */
    public function getPhoto(): ?string
    {
        return null === $this->photo ? null : (string)$this->photo;
    }

    /**
     * Метод возвращает атрибут "Университет" сущности "ВК пользователь".
     *
     * @return string|null
     */
    public function getUniversityName(): ?string
    {
        return null === $this->universityName ? null : (string)$this->universityName;
    }

    /**
     * Метод устанавливает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return UserInterface
     */
    public function setFacultyName(string $value): UserInterface
    {
        $this->facultyName = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Имя" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return UserInterface
     */
    public function setFirstName(string $value): UserInterface
    {
        $this->firstName = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "ВК пользователь".
     *
     * @param int $value Новое значение.
     *
     * @return UserInterface
     */
    public function setId(int $value): UserInterface
    {
        $this->id = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Фамилия" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return UserInterface
     */
    public function setLastName(string $value): UserInterface
    {
        $this->lastName = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return UserInterface
     */
    public function setPhoto(string $value): UserInterface
    {
        $this->photo = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Университет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return UserInterface
     */
    public function setUniversityName(string $value): UserInterface
    {
        $this->universityName = $value;
        return $this;
    }
}
