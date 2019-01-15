<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\validators\user;

use Userstory\ComponentHelpers\helpers\ArrayHelper;
use Userstory\Yii2Forms\validators\rest\AbstractFilterValidator;

/**
 * Валидатор атрибутов фильтра сущности "ВК пользователь".
 *
 * @property string $facultyName    Факультет.
 * @property string $firstName      Имя.
 * @property int    $id             Идентификатор.
 * @property string $lastName       Фамилия.
 * @property string $photo          Факультет.
 * @property string $universityName Университет.
 */
class UserFilterValidator extends AbstractFilterValidator
{
    /**
     * Данный метод возвращает массив, содержащий правила валидации атрибутов.
     *
     * @return array
     */
    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), UserValidator::getRules());
    }
}
