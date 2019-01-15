<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces;

use Userstory\Yii2Dto\interfaces\results\DtoResultInterface;

/**
 * Интерфейс объекта, работающего через результат со ДТО.
 */
interface WithDtoResultInterface
{
    /**
     * Метод возвращает объекта результат.
     *
     * @return DtoResultInterface
     */
    public function getResult();

    /**
     * Метод устанавливает объекта результат.
     *
     * @param DtoResultInterface $result Новое значение.
     *
     * @return static
     */
    public function setResult(DtoResultInterface $result);
}
