<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\interfaces\personType;

use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Forms\interfaces\rest\CreateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\DeleteFormInterface;
use Userstory\Yii2Forms\interfaces\rest\UpdateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\ViewFormInterface;
use Ziganshinalexey\PersonType\interfaces\personType\filters\MultiFilterInterface;

/**
 * Интерфейс фабрики. Опеределяет методы порождения моделей пакета.
 */
interface FactoryInterface
{
    /**
     * Метод возвращает интерфейс формы создания сущности "Тип личности".
     *
     * @return CreateFormInterface
     */
    public function getPersonTypeCreateForm(): CreateFormInterface;

    /**
     * Метод возвращает интерфейс формы удаления сущностей "Тип личности".
     *
     * @return DeleteFormInterface
     */
    public function getPersonTypeDeleteForm(): DeleteFormInterface;

    /**
     * Метод возвращает форму фильтра списка сущностей "Тип личности".
     *
     * @return MultiFilterInterface
     */
    public function getPersonTypeFilter(): MultiFilterInterface;

    /**
     * Метод возвращает гидратор фильтра сущности "Тип личности".
     *
     * @return HydratorInterface
     */
    public function getPersonTypeFilterHydrator(): HydratorInterface;

    /**
     * Метод возвращает гидратор для сущности "Тип личности".
     *
     * @return HydratorInterface
     */
    public function getPersonTypeHydrator(): HydratorInterface;

    /**
     * Метод возвращает интерфейс формы для поиска списка сущностей "Тип личности".
     *
     * @return ListFormInterface
     */
    public function getPersonTypeListForm(): ListFormInterface;

    /**
     * Метод возвращает интерфейс формы обновления сущности "Тип личности".
     *
     * @return UpdateFormInterface
     */
    public function getPersonTypeUpdateForm(): UpdateFormInterface;

    /**
     * Метод возвращает интерфейс формы для просмотра одной сущности "Тип личности".
     *
     * @return ViewFormInterface
     */
    public function getPersonTypeViewForm(): ViewFormInterface;
}
