<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\user\dto;

use Userstory\ComponentBase\interfaces\DataTransferObjectInterface;
use Userstory\ComponentBase\interfaces\ObjectWithErrorsInterface;
use Userstory\ComponentBase\interfaces\PrototypeInterface;

/**
 * Интерфейс требует методы доступа для объекта DTO.
 */
interface UserInterface extends PrototypeInterface, ObjectWithErrorsInterface, DataTransferObjectInterface
{
    /**
     * Метод возвращает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @return string|null
     */
    public function getFacultyName(): ?string;

    /**
     * Метод возвращает атрибут "Имя" сущности "ВК пользователь".
     *
     * @return string|null
     */
    public function getFirstName(): ?string;

    /**
     * Метод возвращает атрибут "Идентификатор" сущности "ВК пользователь".
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Метод возвращает атрибут "Фамилия" сущности "ВК пользователь".
     *
     * @return string|null
     */
    public function getLastName(): ?string;

    /**
     * Метод возвращает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @return string|null
     */
    public function getPhoto(): ?string;

    /**
     * Метод возвращает атрибут "Университет" сущности "ВК пользователь".
     *
     * @return string|null
     */
    public function getUniversityName(): ?string;

    /**
     * Метод устанавливает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return UserInterface
     */
    public function setFacultyName(string $value): UserInterface;

    /**
     * Метод устанавливает атрибут "Имя" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return UserInterface
     */
    public function setFirstName(string $value): UserInterface;

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "ВК пользователь".
     *
     * @param int $value Новое значение.
     *
     * @return UserInterface
     */
    public function setId(int $value): UserInterface;

    /**
     * Метод устанавливает атрибут "Фамилия" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return UserInterface
     */
    public function setLastName(string $value): UserInterface;

    /**
     * Метод устанавливает атрибут "Факультет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return UserInterface
     */
    public function setPhoto(string $value): UserInterface;

    /**
     * Метод устанавливает атрибут "Университет" сущности "ВК пользователь".
     *
     * @param string $value Новое значение.
     *
     * @return UserInterface
     */
    public function setUniversityName(string $value): UserInterface;
}
