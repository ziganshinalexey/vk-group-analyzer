<?php

namespace Userstory\Yii2Forms\forms;

/**
 * Абстрактной класс формы для просмотра данных одной DTO в админке.
 */
abstract class AbstractViewForm extends AbstractForm
{
    /**
     * Ничего не делает - при просмотре ничего делать и не надо.
     * Переопределяется по требованию родителя.
     *
     * @param array $params Параметры формы для выполнения её действия.
     *
     * @inherit
     *
     * @return mixed
     */
    public function run(array $params = [])
    {
        return true;
    }
}
