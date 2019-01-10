<?php

namespace Userstory\ComponentBase\interfaces;

/**
 * Interface ControllerModelInterface
 * Интерфейс для всех сущностей, с которыми работает контроллер.
 *
 * @package Userstory\ComponentBase\interfaces
 */
interface ControllerModelInterface
{
    /**
     * Метод загружает данные сущности.
     *
     * @param array|mixed $data     Данные для загрузки.
     * @param string|null $formName Название формы с данными.
     *
     * @return mixed
     */
    public function load($data, $formName = null);

    /**
     * Сохраняет текущую сущность.
     *
     * @param boolean    $runValidation  Запустить ли валидацию перед сохранением.
     * @param array|null $attributeNames Список атрибутов для сохранения.
     *
     * @return boolean
     */
    public function save($runValidation = true, $attributeNames = null);

    /**
     * Удаляет текущую сущность.
     *
     * @return integer|boolean
     */
    public function delete();
}
