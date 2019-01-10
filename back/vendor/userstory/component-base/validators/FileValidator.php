<?php

namespace Userstory\ComponentBase\validators;

use yii\helpers\Json;
use yii\validators\FileValidator as YiiFileValidator;

/**
 * FileValidator проверяет, что значнием атрибута является валидный файл.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @deprecated функциональность jquery3 теперь уже есть в Yii
 */
class FileValidator extends YiiFileValidator
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
        ValidationAsset::register($view);
        $options = $this->getClientOptions($model, $attribute);
        return 'yii.validation.file(attribute, messages, ' . Json::encode($options) . ');';
    }
}
