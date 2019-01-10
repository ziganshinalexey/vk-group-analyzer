<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\interfaces\personType;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Forms\interfaces\rest\CreateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\DeleteFormInterface;
use Userstory\Yii2Forms\interfaces\rest\UpdateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\ViewFormInterface;

/**
 * Интерфейс компонента для работы с сущностями "Тип личности".
 */
interface RestComponentInterface
{
    /**
     * Метод возвращает интерфейс формы создания сущности "Тип личности".
     *
     * @return CreateFormInterface
     */
    public function getCreateForm(): CreateFormInterface;

    /**
     * Метод возвращает интерфейс формы удаления сущности "Тип личности".
     *
     * @return DeleteFormInterface
     */
    public function getDeleteForm(): DeleteFormInterface;

    /**
     * Метод возвращает интерефейс гидратора фильтра поиска сущности "Тип личности".
     *
     * @return HydratorInterface
     */
    public function getFilterHydrator(): HydratorInterface;

    /**
     * Метод возвращает интерефейс операции поиска списка сущностей "Тип личности".
     *
     * @return ListFormInterface
     */
    public function getListForm(): ListFormInterface;

    /**
     * Метод возвращает интерфейс формы редактирования сущности "Тип личности".
     *
     * @return UpdateFormInterface
     */
    public function getUpdateForm(): UpdateFormInterface;

    /**
     * Метод возвращает интерефейс операции поиска одного экземпляра сущности "Тип личности".
     *
     * @return ViewFormInterface
     */
    public function getViewForm(): ViewFormInterface;
}
