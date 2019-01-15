<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\traits;

/**
 * Трейт объекта, который работает с ИД.
 */
trait WithIdTrait
{
    /**
     * ИД сущности для обработки.
     *
     * @var int|null
     */
    protected $id;

    /**
     * Метод возвращает ИД сущности.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Метод устанавливает ИД сущности.
     *
     * @param int $id Новое значение.
     *
     * @return static
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }
}
