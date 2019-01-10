<?php

namespace Userstory\ComponentBase\validators;

use Userstory\ModuleAdmin\assets\YiiAsset;
use yii\validators\ValidationAsset as YiiValidationAsset;

/**
 * Class ValidationAsset.
 * Данный ассет-банд подключает javascript-файл для клиентской валидации.
 * Переопределение требуется, что бы можно было использовать JQuery3.
 *
 * @deprecated функциональность jquery3 теперь уже есть в Yii
 */
class ValidationAsset extends YiiValidationAsset
{
    /**
     * Инициализирует бандл.
     * Если установлен модуль админки, то устанавливает зависимость от ассета с JQuery3.
     *
     * @return void
     */
    public function init()
    {
        if (class_exists(YiiAsset::class)) {
            $this->depends = [YiiAsset::class];
        }
        parent::init();
    }
}
