<?php

namespace Userstory\ComponentBase\validators;

use yii;
use yii\helpers\Json;
use yii\validators\PunycodeAsset;
use yii\validators\UrlValidator as YiiUrlValidator;
use yii\web\JsExpression;

/**
 * UrlValidator проверяет, что значние атрибута является URL.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @deprecated функциональность jquery3 теперь уже есть в Yii
 */
class UrlValidator extends YiiUrlValidator
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
        if (strpos($this->pattern, '{schemes}') !== false) {
            $pattern = str_replace('{schemes}', '(' . implode('|', $this->validSchemes) . ')', $this->pattern);
        } else {
            $pattern = $this->pattern;
        }

        $options = [
            'pattern'   => new JsExpression($pattern),
            'message'   => Yii::$app->getI18n()->format($this->message, [
                'attribute' => $model->getAttributeLabel($attribute),
            ], Yii::$app->language),
            'enableIDN' => (bool)$this->enableIDN,
        ];
        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }
        if (null !== $this->defaultScheme) {
            $options['defaultScheme'] = $this->defaultScheme;
        }

        ValidationAsset::register($view);
        if ($this->enableIDN) {
            PunycodeAsset::register($view);
        }

        return 'yii.validation.url(value, messages, ' . Json::htmlEncode($options) . ');';
    }
}
