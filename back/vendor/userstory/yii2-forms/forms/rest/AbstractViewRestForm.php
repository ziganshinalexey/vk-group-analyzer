<?php

declare( strict_types = 1 );

namespace Userstory\Yii2Forms\forms\rest;

use Userstory\Yii2Forms\interfaces\rest\ViewFormInterface;

/**
 * Абстрактной класс формы для редактирования одной DTO.
 */
abstract class AbstractViewRestForm extends AbstractQueryParamsRestForm implements ViewFormInterface
{
    /**
     * Метод возвращает объект ДТО для работы с формой.
     *
     * @return null
     */
    public function getPrototype()
    {
        return null;
    }
}
