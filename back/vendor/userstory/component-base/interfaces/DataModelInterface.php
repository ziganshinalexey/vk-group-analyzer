<?php

namespace Userstory\ComponentBase\interfaces;

/**
 * Интерфейс DataModelInterface объявляет реализацию модели данных.
 *
 * @package Userstory\ComponentBase\interfaces
 */
interface DataModelInterface extends PrototypeInterface
{
    /**
     * Метод возвращает название формы модели.
     *
     * @return string
     */
    public function formName();
}
