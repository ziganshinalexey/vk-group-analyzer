<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\interfaces;

use Userstory\ComponentBase\interfaces\PrototypeInterface;
use Userstory\Yii2Errors\interfaces\errors\WithErrorsInterface;

/**
 * Базовый интерфейс для класса ДТО.
 */
interface BaseDtoInterface extends PrototypeInterface, WithErrorsInterface
{
    /**
     * Метод завершает инициализацию ДТО.
     * Данный метод может вызываться например операциями поиска после загрузки данных в ДТО.
     *
     * @param bool $force Выполнять ли операцию повторно.
     *
     * @return void
     */
    public function completeInitialization(bool $force = false): void;
}
