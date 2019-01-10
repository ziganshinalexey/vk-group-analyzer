<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\interfaces\keyword\dto;

use Userstory\ComponentBase\interfaces\DataTransferObjectInterface;
use Userstory\ComponentBase\interfaces\ObjectWithErrorsInterface;
use Userstory\ComponentBase\interfaces\PrototypeInterface;

/**
 * Интерфейс требует методы доступа для объекта DTO.
 */
interface KeywordInterface extends PrototypeInterface, ObjectWithErrorsInterface, DataTransferObjectInterface
{
    /**
     * Метод возвращает атрибут "Идентификатор" сущности "Ключевое фраза".
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Метод возвращает атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @return int
     */
    public function getPersonTypeId(): int;

    /**
     * Метод возвращает атрибут "Название" сущности "Ключевое фраза".
     *
     * @return string
     */
    public function getText(): string;

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "Ключевое фраза".
     *
     * @param int $value Новое значение.
     *
     * @return KeywordInterface
     */
    public function setId(int $value): KeywordInterface;

    /**
     * Метод устанавливает атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @param int $value Новое значение.
     *
     * @return KeywordInterface
     */
    public function setPersonTypeId(int $value): KeywordInterface;

    /**
     * Метод устанавливает атрибут "Название" сущности "Ключевое фраза".
     *
     * @param string $value Новое значение.
     *
     * @return KeywordInterface
     */
    public function setText(string $value): KeywordInterface;
}
