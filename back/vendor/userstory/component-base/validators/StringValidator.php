<?php

namespace Userstory\ComponentBase\validators;

use yii;
use yii\validators\StringValidator as YiiStringValidator;

/**
 * StringValidator проверяет, что значние атрибута является строкой.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @deprecated функциональность jquery3 теперь уже есть в Yii
 */
class StringValidator extends YiiStringValidator
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
            'message' => Yii::$app->getI18n()->format($this->message, [
                'attribute' => $label,
            ], Yii::$app->language),
        ];

        if (null !== $this->min) {
            $options['min']      = $this->min;
            $options['tooShort'] = Yii::$app->getI18n()->format($this->tooShort, [
                'attribute' => $label,
                'min'       => $this->min,
            ], Yii::$app->language);
        }
        if (null !== $this->max) {
            $options['max']     = $this->max;
            $options['tooLong'] = Yii::$app->getI18n()->format($this->tooLong, [
                'attribute' => $label,
                'max'       => $this->max,
            ], Yii::$app->language);
        }
        if (null !== $this->length) {
            $options['is']       = $this->length;
            $options['notEqual'] = Yii::$app->getI18n()->format($this->notEqual, [
                'attribute' => $label,
                'length'    => $this->length,
            ], Yii::$app->language);
        }
        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }

        ValidationAsset::register($view);

        return 'yii.validation.string(value, messages, ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');';
    }
}
