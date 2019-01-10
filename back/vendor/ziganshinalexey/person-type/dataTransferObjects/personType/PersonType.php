<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\dataTransferObjects\personType;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;

/**
 * Реализует логику DTO "Тип личности" для хранения и обмена данными с другими компонентами системы.
 */
class PersonType extends Model implements PersonTypeInterface
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
     * @var string
     */
    protected $name = '';

    /**
     * Метод копирования объекта DTO.
     *
     * @return PersonTypeInterface
     */
    public function copy(): PersonTypeInterface
    {
        return new static();
    }

    /**
     * Метод возвращает атрибут "Идентификатор" сущности "Тип личности".
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return null === $this->id ? null : (int)$this->id;
    }

    /**
     * Метод возвращает атрибут "Название" сущности "Тип личности".
     *
     * @return string
     */
    public function getName(): string
    {
        return (string)$this->name;
    }

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "Тип личности".
     *
     * @param int $value Новое значение.
     *
     * @return PersonTypeInterface
     */
    public function setId(int $value): PersonTypeInterface
    {
        $this->id = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Название" сущности "Тип личности".
     *
     * @param string $value Новое значение.
     *
     * @return PersonTypeInterface
     */
    public function setName(string $value): PersonTypeInterface
    {
        $this->name = $value;
        return $this;
    }
}
