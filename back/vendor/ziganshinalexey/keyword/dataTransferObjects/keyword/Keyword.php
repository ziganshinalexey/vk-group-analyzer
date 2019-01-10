<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\dataTransferObjects\keyword;

use Userstory\ComponentBase\models\Model;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;

/**
 * Реализует логику DTO "Ключевое фраза" для хранения и обмена данными с другими компонентами системы.
 */
class Keyword extends Model implements KeywordInterface
{
    /**
     * Свойство хранит атрибут "Идентификатор" сущности "Ключевое фраза".
     *
     * @var int|null
     */
    protected $id;

    /**
     * Свойство хранит атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @var int
     */
    protected $personTypeId = 0;

    /**
     * Свойство хранит атрибут "Название" сущности "Ключевое фраза".
     *
     * @var string
     */
    protected $text = '';

    /**
     * Метод копирования объекта DTO.
     *
     * @return KeywordInterface
     */
    public function copy(): KeywordInterface
    {
        return new static();
    }

    /**
     * Метод возвращает атрибут "Идентификатор" сущности "Ключевое фраза".
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return null === $this->id ? null : (int)$this->id;
    }

    /**
     * Метод возвращает атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @return int
     */
    public function getPersonTypeId(): int
    {
        return (int)$this->personTypeId;
    }

    /**
     * Метод возвращает атрибут "Название" сущности "Ключевое фраза".
     *
     * @return string
     */
    public function getText(): string
    {
        return (string)$this->text;
    }

    /**
     * Метод устанавливает атрибут "Идентификатор" сущности "Ключевое фраза".
     *
     * @param int $value Новое значение.
     *
     * @return KeywordInterface
     */
    public function setId(int $value): KeywordInterface
    {
        $this->id = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Идентификатор типа личности" сущности "Ключевое фраза".
     *
     * @param int $value Новое значение.
     *
     * @return KeywordInterface
     */
    public function setPersonTypeId(int $value): KeywordInterface
    {
        $this->personTypeId = $value;
        return $this;
    }

    /**
     * Метод устанавливает атрибут "Название" сущности "Ключевое фраза".
     *
     * @param string $value Новое значение.
     *
     * @return KeywordInterface
     */
    public function setText(string $value): KeywordInterface
    {
        $this->text = $value;
        return $this;
    }
}
