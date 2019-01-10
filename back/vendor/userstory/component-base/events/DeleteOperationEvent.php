<?php

declare( strict_types = 1 );

namespace Userstory\ComponentBase\events;

use yii\base\Event;

/**
 * Класс DeleteOperationEvent расширяет базовый класс для передачи фильтр удаления сущности в собитие, если необходимо.
 *
 * @deprecated Следует использовать Userstory\Yii2Events\events\IdListEvent.
 */
class DeleteOperationEvent extends Event
{
    /**
     * Свойство содержит фильтр удаления сущности.
     *
     * @var array|null
     */
    protected $deleteFilter;

    /**
     * Метод задает значение фильтр удаления сущности.
     *
     * @param array $value Новое значение.
     *
     * @return self
     */
    public function setDeleteFilter(array $value): self
    {
        $this->deleteFilter = $value;
        return $this;
    }

    /**
     * Метод возвращает значение фильтр удаления сущности.
     *
     * @return array
     */
    public function getDeleteFilter(): array
    {
        return $this->deleteFilter;
    }
}
