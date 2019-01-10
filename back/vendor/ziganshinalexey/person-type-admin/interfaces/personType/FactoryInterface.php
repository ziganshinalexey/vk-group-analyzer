<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeAdmin\interfaces\personType;

use Ziganshinalexey\PersonTypeAdmin\forms\personType\CreateForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\DeleteForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\FindForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\UpdateForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\ViewForm;

/**
 * Интерфейс фабрики. Опеределяет методы порождения моделей пакета.
 */
interface FactoryInterface
{
    /**
     * Метод возвращает форму для создания сущности "Тип личности".
     *
     * @return CreateForm
     */
    public function getCreateForm(): CreateForm;

    /**
     * Метод возвращает форму для удаления данных сущности "Тип личности".
     *
     * @return DeleteForm
     */
    public function getDeleteForm(): DeleteForm;

    /**
     * Метод возвращает форму для поиска данных сущности "Тип личности".
     *
     * @return FindForm
     */
    public function getFindForm(): FindForm;

    /**
     * Метод возвращает форму для обновления данных сущности "Тип личности".
     *
     * @return UpdateForm
     */
    public function getUpdateForm(): UpdateForm;

    /**
     * Метод возвращает форму для просмотра одного экземпляра сущности "Тип личности".
     *
     * @return ViewForm
     */
    public function getViewForm(): ViewForm;
}
