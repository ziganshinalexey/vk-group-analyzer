<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeAdmin\interfaces\personType;

use Ziganshinalexey\PersonTypeAdmin\forms\personType\CreateForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\DeleteForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\FindForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\UpdateForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\ViewForm;

/**
 * Интерфейс компонента для работы с админкой сущностей "Тип личности".
 */
interface AdminComponentInterface
{
    /**
     * Метод возвращает форму создания экземпляров сущности "Тип личности".
     *
     * @return CreateForm
     */
    public function create(): CreateForm;

    /**
     * Метод возвращает форму удаления экземпляра сущности "Тип личности".
     *
     * @return DeleteForm
     */
    public function delete(): DeleteForm;

    /**
     * Метод возвращает форму поиска экземпляров сущности "Тип личности".
     *
     * @return FindForm
     */
    public function find(): FindForm;

    /**
     * Метод возвращает форму обновления экземпляра сущности "Тип личности".
     *
     * @return UpdateForm
     */
    public function update(): UpdateForm;

    /**
     * Метод возвращает прототип админской модели "Тип личности".
     *
     * @return ViewForm
     */
    public function view(): ViewForm;
}
