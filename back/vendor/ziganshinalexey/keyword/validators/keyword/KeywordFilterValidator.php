<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\validators\keyword;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\Yii2Forms\validators\rest\AbstractFilterValidator;

/**
 * Валидатор атрибутов фильтра сущности "Ключевое фраза".
 *
 * @property int    $id           Идентификатор.
 * @property int    $personTypeId Идентификатор типа личности.
 * @property string $text         Название.
 */
class KeywordFilterValidator extends AbstractFilterValidator
{
    /**
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), KeywordValidator::getRules());
    }
}
