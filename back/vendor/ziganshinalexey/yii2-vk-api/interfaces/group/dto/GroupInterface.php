<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\interfaces\group\dto;

use Userstory\ComponentBase\interfaces\DataTransferObjectInterface;
use Userstory\ComponentBase\interfaces\ObjectWithErrorsInterface;
use Userstory\ComponentBase\interfaces\PrototypeInterface;

/**
 * Интерфейс требует методы доступа для объекта DTO.
 */
interface GroupInterface extends PrototypeInterface, ObjectWithErrorsInterface, DataTransferObjectInterface
{
    /**
     * Метод возвращает атрибут "Название" сущности "ВК группа".
     *
     * @return string|null
     */
    public function getActivity(): ?string;

    /**
     * Метод возвращает атрибут "Название" сущности "ВК группа".
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Метод возвращает атрибут "Идентификатор" сущности "ВК группа".
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Метод возвращает атрибут "Название" сущности "ВК группа".
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
     *
     * @param string $value Новое значение.
     *
     * @return GroupInterface
     */
    public function setActivity(string $value): GroupInterface;

    /**
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
     *
     * @param string $value Новое значение.
     *
     * @return GroupInterface
     */
    public function setDescription(string $value): GroupInterface;

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "ВК группа".
     *
     * @param int $value Новое значение.
     *
     * @return GroupInterface
     */
    public function setId(int $value): GroupInterface;

    /**
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
     *
     * @param string $value Новое значение.
     *
     * @return GroupInterface
     */
    public function setName(string $value): GroupInterface;
}
