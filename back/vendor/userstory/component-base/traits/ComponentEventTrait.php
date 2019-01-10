<?php

namespace Userstory\ComponentBase\traits;

use Userstory\ComponentBase\events\CreateOperationEvent;
use Userstory\ComponentBase\events\DeleteOperationEvent;
use Userstory\ComponentBase\events\FindOperationEvent;
use Userstory\ComponentBase\events\UpdateOperationEvent;

/**
 * Трейт реализует методы вызова события на каждую операцию, так же позволяет навесить несколько обработчиков через конфиг.
 *
 * @deprecated Данный трейт упразднен и оставлен для совместимости версий пакета.
 */
trait ComponentEventTrait
{
    use MultipleHandlersTrait;

    /**
     * Метод вызывает событие для внешних компонентов.
     *
     * @param CreateOperationEvent $event Объект события, при триггере.
     *
     * @return void
     */
    protected function triggerCreate(CreateOperationEvent $event): void
    {
        $this->trigger(self::CREATE_OPERATION_EVENT, $event);
    }

    /**
     * Метод вызывает событие для внешних компонентов.
     *
     * @param DeleteOperationEvent $event Объект события, при триггере.
     *
     * @return void
     */
    protected function triggerDelete(DeleteOperationEvent $event): void
    {
        $this->trigger(self::DELETE_OPERATION_EVENT, $event);
    }

    /**
     * Метод вызывает событие для внешних компонентов.
     *
     * @param FindOperationEvent $event Объект события, при триггере.
     *
     * @return void
     */
    protected function triggerFind(FindOperationEvent $event): void
    {
        $this->trigger(self::FIND_OPERATION_EVENT, $event);
    }

    /**
     * Метод вызывает событие для внешних компонентов.
     *
     * @param UpdateOperationEvent $event Объект события, при триггере.
     *
     * @return void
     */
    protected function triggerUpdate(UpdateOperationEvent $event): void
    {
        $this->trigger(self::UPDATE_OPERATION_EVENT, $event);
    }
}
