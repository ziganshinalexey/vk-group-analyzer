<?php

namespace Userstory\ComponentBase\models;

use Userstory\ComponentBase\traits\ValidatorTrait;
use yii\base\Model as YiiModel;

/**
 * Class Модели. Переопределяет стандартное поведение моделей Yii.
 *
 * @deprecated делалось, что бы подключить jquery3. но функциональность jquery3 теперь уже есть в Yii
 */
class Model extends YiiModel
{
    use ValidatorTrait;
}
