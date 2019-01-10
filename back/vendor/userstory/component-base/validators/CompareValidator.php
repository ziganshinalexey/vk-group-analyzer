<?php

namespace Userstory\ComponentBase\validators;

use yii;
use yii\helpers\Html;
use yii\validators\CompareValidator as YiiCompareValidator;

/**
 * BooleanValidator проверяет, что атрибут имеет такое же значение, как и другой атрибут.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @deprecated функциональность jquery3 теперь уже есть в Yii
 */
class CompareValidator extends YiiCompareValidator
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
            'operator' => $this->operator,
            'type'     => $this->type,
        ];

        if (null !== $this->compareValue) {
            $options['compareValue'] = $this->compareValue;
            $compareValueOrAttribute = $this->compareValue;
            $compareValue            = $this->compareValue;
            $compareLabel            = $this->compareValue;
        } else {
            $compareAttribute            = null === $this->compareAttribute ? $attribute . '_repeat' : $this->compareAttribute;
            $compareValue                = $model->getAttributeLabel($compareAttribute);
            $options['compareAttribute'] = Html::getInputId($model, $compareAttribute);
            $compareValueOrAttribute     = $model->getAttributeLabel($compareAttribute);
            $compareLabel                = $model->getAttributeLabel($compareAttribute);
        }

        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }

        $options['message'] = Yii::$app->getI18n()->format($this->message, [
            'attribute'               => $model->getAttributeLabel($attribute),
            'compareAttribute'        => $compareLabel,
            'compareValue'            => $compareValue,
            'compareValueOrAttribute' => $compareValueOrAttribute,
        ], Yii::$app->language);

        ValidationAsset::register($view);

        return 'yii.validation.compare(value, messages, ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');';
    }
}
