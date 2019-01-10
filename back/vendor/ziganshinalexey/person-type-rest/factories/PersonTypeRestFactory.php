<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\factories;

use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Forms\interfaces\rest\CreateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\DeleteFormInterface;
use Userstory\Yii2Forms\interfaces\rest\UpdateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\ViewFormInterface;
use Userstory\Yii2Forms\validators\rest\AbstractFilterValidator;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;
use Ziganshinalexey\PersonType\interfaces\personType\filters\MultiFilterInterface;
use Ziganshinalexey\PersonType\traits\personType\PersonTypeComponentTrait;
use Ziganshinalexey\PersonTypeRest\interfaces\personType\FactoryInterface;
use Ziganshinalexey\PersonTypeRest\interfaces\personType\ListFormInterface;

/**
 * Фабрика. Реализует породждение моделей пакета для работы с сущностью "Тип личности".
 */
class PersonTypeRestFactory extends ModelsFactory implements FactoryInterface
{
    use PersonTypeComponentTrait;

    public const PERSON_TYPE_CREATE_FORM      = 'personTypeCreateForm';
    public const PERSON_TYPE_DELETE_FORM      = 'personTypeDeleteForm';
    public const PERSON_TYPE_LIST_FORM        = 'personTypeListForm';
    public const PERSON_TYPE_UPDATE_FORM      = 'personTypeUpdateForm';
    public const PERSON_TYPE_VIEW_FORM        = 'personTypeViewForm';
    public const PERSON_TYPE_FILTER           = 'personTypeFilter';
    public const PERSON_TYPE_FILTER_HYDRATOR  = 'personTypeFilterHydrator';
    public const PERSON_TYPE_FILTER_VALIDATOR = 'personTypeFilterValidator';
    public const PERSON_TYPE_HYDRATOR         = 'personTypeHydrator';
    public const PERSON_TYPE_PROTOTYPE        = 'personTypePrototype';

    /**
     * Метод возвращает форму создания сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return CreateFormInterface
     */
    public function getPersonTypeCreateForm(): CreateFormInterface
    {
        return  $this->getModelInstance(self::PERSON_TYPE_CREATE_FORM, [], false)
                     ->setPrototype($this->getPrototype())
                     ->setHydrator($this->getPersonTypeHydrator());
    }

    /**
     * Метод возвращает форму удаления сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return DeleteFormInterface
     */
    public function getPersonTypeDeleteForm(): DeleteFormInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_DELETE_FORM, [], false);
    }

    /**
     * Метод возвращает форму фильтра списка "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return MultiFilterInterface
     */
    public function getPersonTypeFilter(): MultiFilterInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_FILTER, [], false);
    }

    /**
     * Метод возвращает гидратор фильтра списка "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return HydratorInterface
     */
    public function getPersonTypeFilterHydrator(): HydratorInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_FILTER_HYDRATOR, [], false);
    }

    /**
     * Метод возвращает валидатор фильтра сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return AbstractFilterValidator
     */
    protected function getPersonTypeFilterValidator(): AbstractFilterValidator
    {
        return $this->getModelInstance(self::PERSON_TYPE_FILTER_VALIDATOR, [], false);
    }

    /**
     * Метод возвращает гидратор для сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return HydratorInterface
     */
    public function getPersonTypeHydrator(): HydratorInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_HYDRATOR, [], false);
    }

    /**
     * Метод возвращает форму просмотра списка "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return ListFormInterface
     */
    public function getPersonTypeListForm(): ListFormInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_LIST_FORM, [], false)
                    ->setFilter($this->getPersonTypeFilter())
                    ->setFilterValidator($this->getPersonTypeFilterValidator());
    }

    /**
     * Метод возвращает форму редактирования сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return UpdateFormInterface
     */
    public function getPersonTypeUpdateForm(): UpdateFormInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_UPDATE_FORM, [], false)
                    ->setPrototype($this->getPrototype())
                    ->setHydrator($this->getPersonTypeHydrator());
    }

    /**
     * Метод возвращает форму просмотра одной сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return ViewFormInterface
     */
    public function getPersonTypeViewForm(): ViewFormInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_VIEW_FORM, [], false);
    }

    /**
     * Метод возвращает объект прототипа сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return PersonTypeInterface
     */
    protected function getPrototype(): PersonTypeInterface
    {
        return $this->getModelInstance(self::PERSONTYPE_PROTOTYPE, [], false);
    }
}
