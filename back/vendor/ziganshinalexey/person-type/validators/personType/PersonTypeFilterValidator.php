<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\validators\personType;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\Yii2Forms\validators\rest\AbstractFilterValidator;

/**
 * Валидатор атрибутов фильтра сущности "Тип личности".
 *
 * @property int    $id   Идентификатор.
 * @property string $name Название.
 */
class PersonTypeFilterValidator extends AbstractFilterValidator
{
    /**
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), PersonTypeValidator::getRules());
    }
}
