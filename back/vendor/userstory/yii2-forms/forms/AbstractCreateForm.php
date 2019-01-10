<?php

namespace Userstory\Yii2Forms\forms;

use yii;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;

/**
 * Абстрактной класс формы для просмотра редактирования одной DTO в админке.
 */
abstract class AbstractCreateForm extends AbstractForm
{
    /**
     * Осуществлет основное действие формы - добавление элемента.
     *
     * @param array $params Параметры формы для выполнения её действия.
     *
     * @throws InvalidArgumentException Если http-код ответа не верный.
     * @throws InvalidConfigException   Если компонент не зарегистрирован.
     *
     * @inherit
     *
     * @return mixed
     */
    public function run(array $params = [])
    {
        $item = $this->dto;

        $result = $this->getDtoComponent()->createOne($item)->doOperation();
        $item   = $this->getResultItem($result);
        if (false === $item) {
            Yii::$app->response->setStatusCode(500);
            return false;
        }

        if (! $result->isSuccess()) {
            $this->addErrors($item->getErrors());
            return false;
        }

        return $item;
    }

    /**
     * Возвращает первый элемент из списка созданных.
     *
     * @param mixed $result Результат выполнения операции.
     *
     * @return mixed|false
     */
    abstract protected function getResultItem($result);
}
