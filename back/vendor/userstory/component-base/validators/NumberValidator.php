<?php

namespace Userstory\ComponentBase\validators;

use yii;
use yii\helpers\Json;
use yii\validators\NumberValidator as YiiNumberValidator;
use yii\web\JsExpression;

/**
 * NumberValidator проверяет, что значнием атрибута является число.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @deprecated функциональность jquery3 теперь уже есть в Yii
 */
class NumberValidator extends YiiNumberValidator
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
        $label = $model->getAttributeLabel($attribute);

        $options = [
            'pattern' => new JsExpression($this->integerOnly ? $this->integerPattern : $this->numberPattern),
            'message' => Yii::$app->getI18n()->format($this->message, [
                'attribute' => $label,
            ], Yii::$app->language),
        ];

        if (null !== $this->min) {
            // Ensure numeric value to make javascript comparison equal to PHP comparison.
            // Https://github.com/yiisoft/yii2/issues/3118.
            $options['min']      = is_string($this->min) ? (float)$this->min : $this->min;
            $options['tooSmall'] = Yii::$app->getI18n()->format($this->tooSmall, [
                'attribute' => $label,
                'min'       => $this->min,
            ], Yii::$app->language);
        }
        if (null !== $this->max) {
            // Ensure numeric value to make javascript comparison equal to PHP comparison.
            // Https://github.com/yiisoft/yii2/issues/3118.
            $options['max']    = is_string($this->max) ? (float)$this->max : $this->max;
            $options['tooBig'] = Yii::$app->getI18n()->format($this->tooBig, [
                'attribute' => $label,
                'max'       => $this->max,
            ], Yii::$app->language);
        }
        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }

        ValidationAsset::register($view);

        return 'yii.validation.number(value, messages, ' . Json::htmlEncode($options) . ');';
    }
}
