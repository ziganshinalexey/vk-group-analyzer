<?php

namespace Userstory\ComponentBase\interfaces;

/**
 * Интерфейс объявляет методы операции необходимые для работы с событиями.
 *
 * @deprecated Следует использовать Userstory\Yii2Events\interfaces\ObjectWithEventsInterface.
 */
interface EventOperationInterface
{
    public const DO_EVENT = 'DO';

    /**
     * Метод задает обработчик на событие.
     *
     * @param string        $name    Название события.
     * @param callable|null $handler Обработчик события.
     * @param mixed|null    $data    Данные которые будет использовать при триггере.
     * @param boolean       $append  Флаг добавления или замены обработчика.
     *
     * @inherit
     *
     * @return void
     */
    public function on($name, $handler, $data = null, $append = true);
}
