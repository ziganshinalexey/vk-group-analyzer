<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces;

/**
 * Интерфейс объекта, работающего с ДТО.
 */
interface WithDtoInterface
{
    /**
     * Метод возвращает объект ДТО.
     *
     * @return BaseDtoInterface|null
     */
    public function getDto();

    /**
     * Метод устанавливает объект ДТО.
     *
     * @param BaseDtoInterface|null $dtoPrototype Новое значение.
     *
     * @return static
     */
    public function setDto(?BaseDtoInterface $dtoPrototype);
}
