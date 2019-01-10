<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\components;

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\ComponentBase\traits\ModelsFactoryTrait;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Forms\interfaces\rest\CreateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\DeleteFormInterface;
use Userstory\Yii2Forms\interfaces\rest\UpdateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\ViewFormInterface;
use yii\base\Component;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonTypeRest\interfaces\personType\FactoryInterface;
use Ziganshinalexey\PersonTypeRest\interfaces\personType\ListFormInterface;
use Ziganshinalexey\PersonTypeRest\interfaces\personType\RestComponentInterface;
use function get_class;

/**
 * Компонент. Является программным API для доступа к пакету.
 */
class PersonTypeRestComponent extends Component implements ComponentWithFactoryInterface, RestComponentInterface
{
    use ModelsFactoryTrait {
        ModelsFactoryTrait::getModelFactory as getModelFactoryFromTrait;
    }

    /**
     * Метод возвращает форму создания сущности "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return CreateFormInterface
     */
    public function getCreateForm(): CreateFormInterface
    {
        return $this->getModelFactory()->getPersonTypeCreateForm();
    }

    /**
     * Метод возвращает форму удаления сущности "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return DeleteFormInterface
     */
    public function getDeleteForm(): DeleteFormInterface
    {
        return $this->getModelFactory()->getPersonTypeDeleteForm();
    }

    /**
     * Метод возвращает гидратор фильтра поиска сущности "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return HydratorInterface
     */
    public function getFilterHydrator(): HydratorInterface
    {
        return $this->getModelFactory()->getPersonTypeFilterHydrator();
    }

    /**
     * Метод возвращает форму поиска списка сущностей "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return ListFormInterface
     */
    public function getListForm(): ListFormInterface
    {
        return $this->getModelFactory()->getPersonTypeListForm();
    }

    /**
     * Метод возвращает фабрику моделей пакета "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return FactoryInterface
     */
    public function getModelFactory(): FactoryInterface
    {
        $modelFactory = $this->getModelFactoryFromTrait();
        if (! $modelFactory instanceof FactoryInterface) {
            throw new InvalidConfigException('Class ' . get_class($modelFactory) . ' must implement interface ' . FactoryInterface::class);
        }
        return $modelFactory;
    }

    /**
     * Метод возвращает форму редатирования сущности "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return UpdateFormInterface
     */
    public function getUpdateForm(): UpdateFormInterface
    {
        return $this->getModelFactory()->getPersonTypeUpdateForm();
    }

    /**
     * Метод возвращает форму просмотра одной сущности "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return ViewFormInterface
     */
    public function getViewForm(): ViewFormInterface
    {
        return $this->getModelFactory()->getPersonTypeViewForm();
    }
}
