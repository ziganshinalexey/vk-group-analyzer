<?php

namespace Userstory\ComponentBase\validators;

use yii;
use yii\validators\BooleanValidator as YiiBooleanValidator;

/**
 * BooleanValidator проверяет, что атрибут имеет логический тип.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @deprecated функциональность jquery3 теперь уже есть в Yii
 */
class BooleanValidator extends YiiBooleanValidator
{
    /**
     * Возвращает JavaScript, необходимый для валидации на стороне клиента.
     * Переопределение требуется, что бы можно было использовать JQuery3.
     *
     * @param mixed  $model     Модель, которую необходимо валидировать.
     * @param string $attribute Название атрибута, который необходимо валидировать.
     * @param mixed  $view      Объект view, который использует данную модель в рендере.
     *
     * @return string
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $options = [
            'trueValue'  => $this->trueValue,
            'falseValue' => $this->falseValue,
            'message'    => Yii::$app->getI18n()->format($this->message, [
                'attribute' => $model->getAttributeLabel($attribute),
                'true'      => true === $this->trueValue ? 'true' : $this->trueValue,
                'false'     => false === $this->falseValue ? 'false' : $this->falseValue,
            ], Yii::$app->language),
        ];
        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }
        if ($this->strict) {
            $options['strict'] = 1;
        }

        ValidationAsset::register($view);

        return 'yii.validation.boolean(value, messages, ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');';
    }
}
