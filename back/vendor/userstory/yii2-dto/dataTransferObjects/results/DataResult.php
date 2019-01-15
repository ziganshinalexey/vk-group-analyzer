<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\dataTransferObjects\results;

use Userstory\Yii2Dto\interfaces\results\DataResultInterface;

/**
 * Класс результата, основанный на произволном наборе данных.
 */
class DataResult extends BaseResult implements DataResultInterface
{
    /**
     * Данные результата выполнения той или иной операции.
     *
     * @var mixed|null
     */
    protected $data;

    /**
     * Метод возвращает данные результата.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Метод устанавливает данные результата.
     *
     * @param mixed $data Новое значение.
     *
     * @return static
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}
