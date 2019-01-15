<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces\results;

/**
 * Интерфейс результата для работы через произвольный набор данных.
 */
interface DataResultInterface extends BaseResultInterface
{
    /**
     * Метод возвращает данные результата.
     *
     * @return mixed
     */
    public function getData();

    /**
     * Метод устанавливает данные результата.
     *
     * @param mixed $data Новое значение.
     *
     * @return DataResultInterface
     */
    public function setData($data);
}
