<?php

namespace Userstory\Yii2Forms\forms;

use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\data\ArrayDataProvider;

/**
 * Абстрактной класс формы для просмотра редактирования одной DTO в админке.
 */
abstract class AbstractFindForm extends AbstractForm
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
        $this->load($params);

        $findOperation = $this->getDtoComponent()->findMany();
        $this->makeFilter($findOperation);

        /* @var array $models */
        $models = $findOperation->doOperation();
        foreach ($models as $key => $model) {
            $adminModel = $this->getAdminComponent()->view();
            $adminModel->setDto($model);
            $models[$key] = $adminModel;
        }

        return $this->getDataProvider($models);
    }

    /**
     * Все обращения на чтение атрибутов проктирует на DTO.
     *
     * @param string|mixed $name Название запрашиваемого атрибута.
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        if (! property_exists($this, $name)) {
            return null;
        }
        return $this->$name;
    }

    /**
     * Все обращения на запись атрибутов проктирует на DTO.
     *
     * @param string|mixed $name  Название устанавливаемого атрибута.
     * @param mixed        $value Значение устанавливаемого атрибута.
     *
     * @return void
     */
    public function __set($name, $value)
    {
        if (! property_exists($this, $name)) {
            return;
        }
        $this->$name = $value;
    }

    /**
     * В операции поиска устанавливает критерии фильтрации.
     *
     * @param mixed $findOperation Операция поиска.
     *
     * @return void
     */
    abstract protected function makeFilter($findOperation): void;

    /**
     * Методо должен возвращаать компонент админки.
     *
     * @return mixed
     */
    abstract protected function getAdminComponent();

    /**
     * Возвращает дата-провайдер для отображения списка в таблице.
     *
     * @param array $models Массив моделей для отображения.
     *
     * @return ArrayDataProvider
     */
    protected function getDataProvider(array $models): ArrayDataProvider
    {
        return new ArrayDataProvider([
            'allModels'  => $models,
            'key'        => 'id',
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort'       => [
                'attributes' => ['id'],
            ],
        ]);
    }
}
