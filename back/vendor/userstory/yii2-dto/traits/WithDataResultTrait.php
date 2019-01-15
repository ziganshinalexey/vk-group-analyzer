<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\traits;

use Userstory\Yii2Dto\interfaces\results\DataResultInterface;

/**
 * Трейт объекта, работающего через результат с произвольным набором данных.
 */
trait WithDataResultTrait
{
    /**
     * Объект класса-результата для работы.
     *
     * @var DataResultInterface|null
     */
    protected $result;

    /**
     * Метод возвращает объекта результат.
     * Строгой типизации нет специально для возможности наследования.
     *
     * @return DataResultInterface
     */
    public function getResult(): DataResultInterface
    {
        return $this->result;
    }

    /**
     * Метод устанавливает объекта результат.
     *
     * @param DataResultInterface $result Новое значение.
     *
     * @return static
     */
    public function setResult(DataResultInterface $result)
    {
        $this->result = $result;
        return $this;
    }
}
