<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces;

use Userstory\Yii2Dto\interfaces\results\IdListResultInterface;

/**
 * Интерфейс объекта, работающего через результат со списокм ИД.
 */
interface WithIdListResultInterface
{
    /**
     * Метод возвращает объекта результат.
     *
     * @return IdListResultInterface
     */
    public function getResult(): IdListResultInterface;

    /**
     * Метод устанавливает объекта результат.
     *
     * @param IdListResultInterface $resultPrototype Новое значение.
     *
     * @return static
     */
    public function setResult(IdListResultInterface $resultPrototype);
}
