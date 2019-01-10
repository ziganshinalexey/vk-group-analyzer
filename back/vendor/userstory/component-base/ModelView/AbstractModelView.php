<?php

namespace Userstory\ComponentBase\ModelView;

use Userstory\ComponentBase\interfaces\ModelViewInterface;
use yii\base\Action;

/**
 * Абстрактный класс для определения ModelView по действию.
 *
 * @deprecated
 */
abstract class AbstractModelView implements ModelViewInterface
{
    /**
     * Текущее действие контроллера.
     *
     * @var Action|null
     *
     * @deprecated
     */
    protected $action;

    /**
     * Сеттер для выполняемого контроллером действия.
     *
     * @param Action $action выполняемое действие контроллера.
     *
     * @deprecated
     *
     * @return static
     */
    public function setAction(Action $action)
    {
        $this->action = $action;

        return $this;
    }
}
