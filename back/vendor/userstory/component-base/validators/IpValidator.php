<?php

namespace Userstory\ComponentBase\validators;

use yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\validators\IpValidator as YiiIpValidator;
use yii\web\JsExpression;

/**
 * IpValidator проверяет, что значнием атрибута является корректный IP-адрес.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @deprecated функциональность jquery3 теперь уже есть в Yii
 */
class IpValidator extends YiiIpValidator
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
        $messages = [
            'ipv6NotAllowed' => $this->ipv6NotAllowed,
            'ipv4NotAllowed' => $this->ipv4NotAllowed,
            'message'        => $this->message,
            'noSubnet'       => $this->noSubnet,
            'hasSubnet'      => $this->hasSubnet,
        ];
        foreach ($messages as &$message) {
            $message = Yii::$app->getI18n()->format($message, [
                'attribute' => $model->getAttributeLabel($attribute),
            ], Yii::$app->language);
        }

        $options = [
            'ipv4Pattern'    => new JsExpression(Html::escapeJsRegularExpression($this->ipv4Pattern)),
            'ipv6Pattern'    => new JsExpression(Html::escapeJsRegularExpression($this->ipv6Pattern)),
            'messages'       => $messages,
            'ipv4'           => (bool)$this->ipv4,
            'ipv6'           => (bool)$this->ipv6,
            'ipParsePattern' => new JsExpression(Html::escapeJsRegularExpression($this->getIpParsePattern())),
            'negation'       => $this->negation,
            'subnet'         => $this->subnet,
        ];
        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }

        ValidationAsset::register($view);

        return 'yii.validation.ip(value, messages, ' . Json::htmlEncode($options) . ');';
    }
}
