<?php

namespace Userstory\ComponentBase\validators;

use yii;
use yii\helpers\Json;
use yii\validators\EmailValidator as YiiEmailValidator;
use yii\validators\PunycodeAsset;
use yii\web\JsExpression;

/**
 * EmailValidator проверяет, что значнием атрибута является email.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @deprecated функциональность jquery3 теперь уже есть в Yii
 */
class EmailValidator extends YiiEmailValidator
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
            'pattern'     => new JsExpression($this->pattern),
            'fullPattern' => new JsExpression($this->fullPattern),
            'allowName'   => $this->allowName,
            'message'     => Yii::$app->getI18n()->format($this->message, [
                'attribute' => $model->getAttributeLabel($attribute),
            ], Yii::$app->language),
            'enableIDN'   => (bool)$this->enableIDN,
        ];
        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }

        ValidationAsset::register($view);
        if ($this->enableIDN) {
            PunycodeAsset::register($view);
        }

        return 'yii.validation.email(value, messages, ' . Json::htmlEncode($options) . ');';
    }
}
