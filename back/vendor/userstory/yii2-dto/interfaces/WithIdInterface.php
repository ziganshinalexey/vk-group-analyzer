<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces;

/**
 * Интерфейс объекта, работающего с ИД.
 */
interface WithIdInterface
{
    /**
     * Метод возвращает ИД сущности.
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Метод устанавливает ИД сущности.
     *
     * @param int $id Новое значение.
     *
     * @return static
     */
    public function setId(int $id);
}
