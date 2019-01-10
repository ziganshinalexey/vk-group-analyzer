<?php

namespace Userstory\Yii2Forms\forms;

use yii\base\InvalidConfigException;

/**
 * Абстрактной класс формы для просмотра редактирования одной DTO в админке.
 */
abstract class AbstractUpdateForm extends AbstractForm
{
    /**
     * Осуществлет основное действие формы - обновление элемента.
     *
     * @param array $params Параметры формы для выполнения её действия.
     *
     * @throws InvalidConfigException Если dtoComponent не установлен.
     *
     * @inherit
     *
     * @return mixed
     */
    public function run(array $params = [])
    {
        $result = $this->getDtoComponent()->updateOne($this->dto)->doOperation();
        if (! $result->isSuccess()) {
            $this->addErrors($result->getErrors());
            return false;
        }
        return true;
    }
}
