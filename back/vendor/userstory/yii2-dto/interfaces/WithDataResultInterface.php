<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces;

use Userstory\Yii2Dto\interfaces\results\DataResultInterface;

/**
 * Интерфейс объекта, работающего через результат с произвольным набором данных.
 */
interface WithDataResultInterface
{
    /**
     * Метод возвращает объекта результат.
     *
     * @return DataResultInterface
     */
    public function getResult(): DataResultInterface;

    /**
     * Метод устанавливает объекта результат.
     *
     * @param DataResultInterface $result Новое значение.
     *
     * @return static
     */
    public function setResult(DataResultInterface $result);
}
