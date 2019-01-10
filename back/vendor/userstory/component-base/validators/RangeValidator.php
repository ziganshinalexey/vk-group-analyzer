<?php

namespace Userstory\ComponentBase\validators;

use yii;
use yii\validators\RangeValidator as YiiRangeValidator;
use \Closure;

/**
 * RangeValidator проверяет, что значние атрибута входит в указанный список.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @deprecated функциональность jquery3 теперь уже есть в Yii
 */
class RangeValidator extends YiiRangeValidator
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
        if ($this->range instanceof Closure) {
            $this->range = call_user_func($this->range, $model, $attribute);
        }

        $range = [];
        foreach ($this->range as $value) {
            $range[] = (string)$value;
        }
        $options = [
            'range'   => $range,
            'not'     => $this->not,
            'message' => Yii::$app->getI18n()->format($this->message, [
                'attribute' => $model->getAttributeLabel($attribute),
            ], Yii::$app->language),
        ];
        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }
        if ($this->allowArray) {
            $options['allowArray'] = 1;
        }

        ValidationAsset::register($view);

        return 'yii.validation.range(value, messages, ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');';
    }
}
