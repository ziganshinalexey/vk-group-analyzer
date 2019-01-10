<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\interfaces\personType\dto;

use Userstory\ComponentBase\interfaces\DataTransferObjectInterface;
use Userstory\ComponentBase\interfaces\ObjectWithErrorsInterface;
use Userstory\ComponentBase\interfaces\PrototypeInterface;

/**
 * Интерфейс требует методы доступа для объекта DTO.
 */
interface PersonTypeInterface extends PrototypeInterface, ObjectWithErrorsInterface, DataTransferObjectInterface
{
    /**
     * Метод возвращает атрибут "Идентификатор" сущности "Тип личности".
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Метод возвращает атрибут "Название" сущности "Тип личности".
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "Тип личности".
     *
     * @param int $value Новое значение.
     *
     * @return PersonTypeInterface
     */
    public function setId(int $value): PersonTypeInterface;

    /**
     * Метод устанавливает атрибут "Название" сущности "Тип личности".
     *
     * @param string $value Новое значение.
     *
     * @return PersonTypeInterface
     */
    public function setName(string $value): PersonTypeInterface;
}
