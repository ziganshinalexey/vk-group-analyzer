<?php

declare(strict_types = 1);

namespace app\api\v1\forms\vk;

use yii\base\Model;

/**
 * Форма данных для REST-метода выборки сущности "Ключевое фраза".
 */
class AnalyzeForm extends Model
{

    /**
     * Осуществлет основное действие формы - просмотр элемента.
     *
     * @param array $params Параметры формы для выполнения её действия.
     *
     * @inherit
     *
     * @return null
     */
    public function run(array $params = [])
    {
        if (! $this->validate()) {
            return null;
        }

        return null;
    }
}
