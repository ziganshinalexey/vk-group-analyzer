<?php

declare(strict_types = 1);

namespace Userstory\ComponentBase\events;

use yii\base\Event;
use yii\base\Model;

/**
 * Класс UpdateOperationEvent расширяет базовый класс для передачи ДТО в собитие, если необходимо.
 *
 * @deprecated Следует использовать Userstory\Yii2Events\events\DtoEvent.
 */
class UpdateOperationEvent extends Event
{
    /**
     * Свойство содержит объект ДТО.
     *
     * @var Model|null
     */
    protected $dataTransferObject;

    /**
     * Метод задает значение ДТО.
     *
     * @param Model $value Новое значение.
     *
     * @return self
     */
    public function setDataTransferObject(Model $value): self
    {
        $this->dataTransferObject = $value;
        return $this;
    }

    /**
     * Метод возвращает значение ДТО.
     *
     * @return Model
     */
    public function getDataTransferObject(): Model
    {
        return $this->dataTransferObject;
    }
}
