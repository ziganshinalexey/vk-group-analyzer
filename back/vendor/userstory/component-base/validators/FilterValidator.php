<?php

namespace Userstory\ComponentBase\validators;

use yii\validators\FilterValidator as YiiFilterValidator;

/**
 * FilterValidator преобразует значение атрибута в соответствие с заданным фильтром.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @deprecated функциональность jquery3 теперь уже есть в Yii
 */
class FilterValidator extends YiiFilterValidator
{
    /**
     * Возвращает JavaScript, необходимый для валидации на стороне клиента.
     * Переопределение требуется, что бы можно было использовать JQuery3.
     *
     * @param mixed  $model     Модель, которую необходимо валидировать.
     * @param string $attribute Название атрибута, который необходимо валидировать.
     * @param mixed  $view      Объект view, который использует данную модель в рендере.
     *
     * @inherit
     *
     * @return string
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        if ('trim' !== $this->filter) {
            return null;
        }

        $options = [];
        if ($this->skipOnEmpty) {
            $options['skipOnEmpty'] = 1;
        }

        ValidationAsset::register($view);

        return 'value = yii.validation.trim($form, attribute, ' . json_encode($options, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');';
    }
}
