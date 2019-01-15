<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\traits;

use Userstory\Yii2Dto\interfaces\results\IdResultInterface;

/**
 * Трейт объекта, работающего через результат с ИД.
 */
trait WithIdResultTrait
{
    /**
     * Объект класса-результата для работы.
     *
     * @var IdResultInterface|null
     */
    protected $result;

    /**
     * Метод возвращает объекта результат.
     * Строгой типизации нет специально для возможности наследования.
     *
     * @return IdResultInterface
     */
    public function getResult(): IdResultInterface
    {
        return $this->result;
    }

    /**
     * Метод устанавливает объекта результат.
     *
     * @param IdResultInterface $result Новое значение.
     *
     * @return static
     */
    public function setResult(IdResultInterface $result)
    {
        $this->result = $result;
        return $this;
    }
}
