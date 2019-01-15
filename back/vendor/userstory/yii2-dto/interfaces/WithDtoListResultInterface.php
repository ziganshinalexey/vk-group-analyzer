<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces;

use Userstory\Yii2Dto\interfaces\results\DtoListResultInterface;

/**
 * Интерфейс объекта, работающего через результат со списокм ДТО.
 */
interface WithDtoListResultInterface
{
    /**
     * Метод возвращает объекта результат.
     *
     * @return DtoListResultInterface
     */
    public function getResult();

    /**
     * Метод устанавливает объекта результат.
     *
     * @param DtoListResultInterface $result Новое значение.
     *
     * @return static
     */
    public function setResult(DtoListResultInterface $result);
}
