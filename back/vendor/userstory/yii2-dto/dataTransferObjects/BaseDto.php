<?php

declare(strict_types = 1);

namespace Userstory\Yii2Dto\dataTransferObjects;

use Userstory\Yii2Dto\interfaces\BaseDtoInterface;
use Userstory\Yii2Errors\traits\errors\WithErrorsTrait;
use function DeepCopy\deep_copy;
use yii\base\InvalidConfigException;

/**
 * Класс BaseDto.
 * Базовый класс ДТО.
 */
class BaseDto implements BaseDtoInterface
{
    use WithErrorsTrait;

    /**
     * Флаг, хранящий информацию о том, завершена ли инициализация.
     *
     * @var bool
     */
    protected $initializationCompleted = false;

    /**
     * Метод завершает инициализацию ДТО.
     * Данный метод может вызываться например операциями поиска после загрузки данных в ДТО.
     *
     * @param bool $force Выполнять ли операцию повторно.
     *
     * @return void
     *
     * @throws InvalidConfigException Исключение генерируется в случае неверной конфигурации.
     */
    public function completeInitialization(bool $force = false): void
    {
        if ($force || ! $this->initializationCompleted) {
            $this->clearUSErrors();
            $this->initializationCompleted = true;
        }
    }

    /**
     * Метод возвращает копию текущего объекта.
     *
     * @return static
     */
    public function copy()
    {
        return deep_copy($this);
    }
}
