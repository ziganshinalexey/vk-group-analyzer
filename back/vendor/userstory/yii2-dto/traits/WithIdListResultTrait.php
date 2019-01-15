<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\traits;

use Userstory\Yii2Dto\interfaces\results\IdListResultInterface;

/**
 * Трейт объекта, работающего через результат со списком ИД.
 */
trait WithIdListResultTrait
{
    /**
     * Объект класса-результата для работы.
     *
     * @var IdListResultInterface|null
     */
    protected $result;

    /**
     * Метод возвращает объекта результат.
     * Строгой типизации нет специально для возможности наследования.
     *
     * @return IdListResultInterface
     */
    public function getResult(): IdListResultInterface
    {
        return $this->result;
    }

    /**
     * Метод устанавливает объекта результат.
     *
     * @param IdListResultInterface $result Новое значение.
     *
     * @return static
     */
    public function setResult(IdListResultInterface $result)
    {
        $this->result = $result;
        return $this;
    }
}
