<?php

namespace Userstory\ComponentBase\traits;

use ArrayObject;
use Userstory\ComponentBase\validators\Validator;
use yii\base\InvalidConfigException;

/**
 * Trait InsertAuthTrait.
 * Трейт нужен, что бы переопределить стандартные валидаторы Yii, а это необходимо что бы использовать jquery3.
 *
 * @deprecated функциональность jquery3 теперь уже есть в Yii
 */
trait ValidatorTrait
{
    /**
     * Создает объекты-валидаторы на основе правил модели описанных в [[rules()]].
     * Метод переопределен, что можно было использовать переопределенные валидаторы.
     * А это требуется что бы подключить последнюю версию jquery.
     *
     * @return ArrayObject Валидаторы
     * @throws InvalidConfigException Если правило валидации не верное.
     */
    public function createValidators()
    {
        $validators = new ArrayObject();
        foreach ($this->rules() as $rule) {
            if ($rule instanceof Validator) {
                $validators->append($rule);
            } elseif (is_array($rule) && isset($rule[0], $rule[1])) {
                $validator = Validator::createValidator($rule[1], $this, (array)$rule[0], array_slice($rule, 2));
                $validators->append($validator);
            } else {
                throw new InvalidConfigException('Invalid validation rule: a rule must specify both attribute names and validator type.');
            }
        }
        return $validators;
    }
}
