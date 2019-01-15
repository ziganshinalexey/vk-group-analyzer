<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\dataTransferObjects\group;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;

/**
 * Реализует логику DTO "ВК группа" для хранения и обмена данными с другими компонентами системы.
 */
class Group extends Model implements GroupInterface
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
     * Метод копирования объекта DTO.
     *
     * @return GroupInterface
     */
    public function copy(): GroupInterface
    {
        return new static();
    }

    /**
     * Метод возвращает атрибут "Название" сущности "ВК группа".
     *
     * @return string|null
     */
    public function getActivity(): ?string
    {
        return null === $this->activity ? null : (string)$this->activity;
    }

    /**
     * Метод возвращает атрибут "Название" сущности "ВК группа".
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return null === $this->description ? null : (string)$this->description;
    }

    /**
     * Метод возвращает атрибут "Идентификатор" сущности "ВК группа".
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return null === $this->id ? null : (int)$this->id;
    }

    /**
     * Метод возвращает атрибут "Название" сущности "ВК группа".
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return null === $this->name ? null : (string)$this->name;
    }

    /**
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
     *
     * @param string $value Новое значение.
     *
     * @return GroupInterface
     */
    public function setActivity(string $value): GroupInterface
    {
        $this->activity = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
     *
     * @param string $value Новое значение.
     *
     * @return GroupInterface
     */
    public function setDescription(string $value): GroupInterface
    {
        $this->description = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "ВК группа".
     *
     * @param int $value Новое значение.
     *
     * @return GroupInterface
     */
    public function setId(int $value): GroupInterface
    {
        $this->id = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Название" сущности "ВК группа".
     *
     * @param string $value Новое значение.
     *
     * @return GroupInterface
     */
    public function setName(string $value): GroupInterface
    {
        $this->name = $value;
        return $this;
    }
}
