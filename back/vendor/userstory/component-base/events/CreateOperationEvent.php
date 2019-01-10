<?php

declare( strict_types = 1 );

namespace Userstory\ComponentBase\events;

use yii\base\Event;
use yii\base\Model;

/**
 * Класс CreateOperationEvent расширяет базовый класс для передачи ДТО в собитие, если необходимо.
 *
 * @deprecated Следует использовать Userstory\Yii2Events\events\DtoListEvent.
 */
class CreateOperationEvent extends Event
{
    /**
     * Свойство содержит список ДТО.
     *
     * @var Model[]|null
     */
    protected $dataTransferObjectList;

    /**
     * Метод задает значение списка ДТО.
     *
     * @param Model[] $value Новое значение.
     *
     * @return self
     */
    public function setDataTransferObjectList(array $value): self
    {
        $this->dataTransferObjectList = $value;
        return $this;
    }

    /**
     * Метод возвращает значение списка ДТО.
     *
     * @return Model[]
     */
    public function getDataTransferObjectList(): array
    {
        return $this->dataTransferObjectList;
    }
}
