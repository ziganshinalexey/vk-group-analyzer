<?php

declare( strict_types = 1 );

namespace Userstory\Yii2Forms\interfaces\rest;

use InvalidArgumentException;
use Userstory\ComponentBase\interfaces\DataTransferObjectInterface;
use yii\base\InvalidConfigException;

/**
 * Интерфейс для абстрактной REST формы.
 */
interface AbstractFormInterface
{
    /**
     * Переопределенный метод валидации формы.
     *
     * @param mixed|null $attributeNames Список атрибутов для валидации.
     * @param boolean    $clearErrors    Флаг очистки ошибок перед валидацией.
     *
     * @return boolean
     *
     * @inherit
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     */
    public function validate($attributeNames = null, $clearErrors = true);

    /**
     * Переопределенный метод загрузки формы.
     *
     * @param array|null  $data     Данные для загрузки.
     * @param string|null $formName Название формы.
     *
     * @return boolean
     *
     * @inherit
     *
     * @throws InvalidConfigException Если компонент не зарегистрирован.
     */
    public function load($data, $formName = null);

    /**
     * Метод возвращает ошибки для всех атрибутов или для конкретного.
     *
     * @param string|null $attribute Имя атрибута для которого необходимо вывести ошибки.
     *
     * @inherit
     *
     * @return array
     */
    public function getErrors($attribute = null);

    /**
     * Метод задает значение гидратору.
     *
     * @param string $value Новое значение.
     *
     * @return AbstractFormInterface
     */
    public function setHydrator($value): AbstractFormInterface;

    /**
     * Метод задает значение ДТО для работы с формой.
     *
     * @param DataTransferObjectInterface $value Новое значение.
     *
     * @return AbstractFormInterface
     */
    public function setPrototype(DataTransferObjectInterface $value): AbstractFormInterface;

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
    public function run(array $params = []);
}
