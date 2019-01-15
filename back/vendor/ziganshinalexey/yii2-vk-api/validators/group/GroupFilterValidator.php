<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\validators\group;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\Yii2Forms\validators\rest\AbstractFilterValidator;

/**
 * Валидатор атрибутов фильтра сущности "ВК группа".
 *
 * @property string $activity    Название.
 * @property string $description Название.
 * @property int    $id          Идентификатор.
 * @property string $name        Название.
 */
class GroupFilterValidator extends AbstractFilterValidator
{
    /**
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), GroupValidator::getRules());
    }
}
