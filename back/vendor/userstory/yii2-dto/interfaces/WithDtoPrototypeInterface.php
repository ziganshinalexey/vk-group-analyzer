<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces;

/**
 * Интерфейс объекта, работающего с прототипом ДТО.
 */
interface WithDtoPrototypeInterface
{
    /**
     * Метод возвращает прототип ДТО.
     *
     * @return BaseDtoInterface
     */
    public function getDtoPrototype();

    /**
     * Метод устанавлиает прототип ДТО.
     *
     * @param BaseDtoInterface $dtoPrototype Новое значение.
     *
     * @return static
     */
    public function setDtoPrototype(BaseDtoInterface $dtoPrototype);
}
