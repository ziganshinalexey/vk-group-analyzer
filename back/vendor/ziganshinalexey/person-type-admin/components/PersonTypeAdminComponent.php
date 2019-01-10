<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeAdmin\components;

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\ComponentBase\traits\ModelsFactoryTrait;
use yii\base\Component;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\CreateForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\DeleteForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\FindForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\UpdateForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\ViewForm;
use Ziganshinalexey\PersonTypeAdmin\interfaces\personType\AdminComponentInterface;
use Ziganshinalexey\PersonTypeAdmin\interfaces\personType\FactoryInterface;
use function get_class;

/**
 * Компонент. Является программным API для доступа к пакету.
 */
class PersonTypeAdminComponent extends Component implements ComponentWithFactoryInterface, AdminComponentInterface
{
    use ModelsFactoryTrait {
        ModelsFactoryTrait::getModelFactory as getModelFactoryFromTrait;
    }

    /**
     * Метод возвращает форму создания экземпляров сущности "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return CreateForm
     */
    public function create(): CreateForm
    {
        return $this->getModelFactory()->getCreateForm();
    }

    /**
     * Метод возвращает форму удаления экземпляра сущности "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return DeleteForm
     */
    public function delete(): DeleteForm
    {
        return $this->getModelFactory()->getDeleteForm();
    }

    /**
     * Метод возвращает форму поиска экземпляров сущности "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return FindForm
     */
    public function find(): FindForm
    {
        return $this->getModelFactory()->getFindForm();
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
     * Метод возвращает форму обновления экземпляра сущности "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return UpdateForm
     */
    public function update(): UpdateForm
    {
        return $this->getModelFactory()->getUpdateForm();
    }

    /**
     * Метод возвращает прототип админской модели "Тип личности".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return ViewForm
     */
    public function view(): ViewForm
    {
        return $this->getModelFactory()->getViewForm();
    }
}
