<?php

namespace Userstory\ComponentBase\interfaces;

/**
 * Интерфейс BaseOperationResultInterface.
 * Базовый интерфейс для объекта-результата выполнения операции.
 *
 * @package UserstoryDelivery\Geoobjects
 */
interface BaseOperationResultInterface extends ObjectWithErrorsInterface
{
    /**
     * Мето определяет была ли операция успешно выполнена.
     *
     * @return boolean
     */
    public function isSuccess();
}
