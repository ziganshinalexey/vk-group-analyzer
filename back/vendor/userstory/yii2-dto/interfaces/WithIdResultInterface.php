<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces;

use Userstory\Yii2Dto\interfaces\results\IdResultInterface;

/**
 * Интерфейс объекта, работающего через результат с ИД.
 */
interface WithIdResultInterface
{
    /**
     * Метод возвращает объекта результат.
     *
     * @return IdResultInterface
     */
    public function getResult(): IdResultInterface;

    /**
     * Метод устанавливает объекта результат.
     *
     * @param IdResultInterface $result Новое значение.
     *
     * @return static
     */
    public function setResult(IdResultInterface $result);
}
