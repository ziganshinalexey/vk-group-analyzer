<?php

declare( strict_types = 1 );

namespace Userstory\Yii2Forms\forms\rest;

use Userstory\Yii2Forms\interfaces\rest\DeleteFormInterface;

/**
 * Абстрактной класс формы для удаления DTO.
 */
abstract class AbstractDeleteRestForm extends AbstractQueryParamsRestForm implements DeleteFormInterface
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
