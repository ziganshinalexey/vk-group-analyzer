<?php

namespace Userstory\Yii2Forms\forms;

use yii\base\InvalidConfigException;

/**
 * Абстрактной класс формы для просмотра редактирования одной DTO в админке.
 */
abstract class AbstractDeleteForm extends AbstractForm
{
    /**
     * Осуществлет основное действие формы - удаление элемента.
     *
     * @param array $params Параметры формы для выполнения её действия.
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     *
     * @inherit
     *
     * @return mixed
     */
    public function run(array $params = [])
    {
        $result = $this->getDtoComponent()->deleteMany()->byId($this->dto->getId())->doOperation();
        if (! $result->isSuccess()) {
            $this->addErrors($result->getErrors());
            return false;
        }
        return true;
    }
}
