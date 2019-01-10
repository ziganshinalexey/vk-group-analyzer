<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeAdmin\factories;

use Userstory\ComponentBase\models\ModelsFactory;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\CreateForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\DeleteForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\FindForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\UpdateForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\ViewForm;
use Ziganshinalexey\PersonTypeAdmin\interfaces\personType\FactoryInterface;

/**
 * Фабрика. Реализует породждение моделей пакета для работы админки с сущностью "Тип личности".
 */
class PersonTypeAdminFactory extends ModelsFactory implements FactoryInterface
{
    public const PERSON_TYPE_VIEW_FORM   = 'personTypeViewForm';
    public const PERSON_TYPE_CREATE_FORM = 'personTypeCreateForm';
    public const PERSON_TYPE_UPDATE_FORM = 'personTypeUpdateForm';
    public const PERSON_TYPE_DELETE_FORM = 'personTypeDeleteForm';
    public const PERSON_TYPE_FIND_FORM   = 'personTypeFindForm';

    /**
     * Метод возвращает форму для создания сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return CreateForm
     */
    public function getCreateForm(): CreateForm
    {
        return $this->getModelInstance(self::PERSON_TYPE_CREATE_FORM, [], false);
    }

    /**
     * Метод возвращает форму для удаления данных сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return DeleteForm
     */
    public function getDeleteForm(): DeleteForm
    {
        return $this->getModelInstance(self::PERSON_TYPE_DELETE_FORM, [], false);
    }

    /**
     * Метод возвращает форму для поиска данных сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return FindForm
     */
    public function getFindForm(): FindForm
    {
        return $this->getModelInstance(self::PERSON_TYPE_FIND_FORM, [], false);
    }

    /**
     * Метод возвращает форму для обновления данных сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return UpdateForm
     */
    public function getUpdateForm(): UpdateForm
    {
        return $this->getModelInstance(self::PERSON_TYPE_UPDATE_FORM, [], false);
    }

    /**
     * Метод возвращает форму для просмотра одного экземпляра сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return ViewForm
     */
    public function getViewForm(): ViewForm
    {
        return $this->getModelInstance(self::PERSON_TYPE_VIEW_FORM, [], false);
    }
}
