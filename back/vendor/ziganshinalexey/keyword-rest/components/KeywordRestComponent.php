<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\components;

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\ComponentBase\traits\ModelsFactoryTrait;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Forms\interfaces\rest\CreateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\DeleteFormInterface;
use Userstory\Yii2Forms\interfaces\rest\UpdateFormInterface;
use Userstory\Yii2Forms\interfaces\rest\ViewFormInterface;
use yii\base\Component;
use yii\base\InvalidConfigException;
use Ziganshinalexey\KeywordRest\interfaces\keyword\FactoryInterface;
use Ziganshinalexey\KeywordRest\interfaces\keyword\ListFormInterface;
use Ziganshinalexey\KeywordRest\interfaces\keyword\RestComponentInterface;
use function get_class;

/**
 * Компонент. Является программным API для доступа к пакету.
 */
class KeywordRestComponent extends Component implements ComponentWithFactoryInterface, RestComponentInterface
{
    use ModelsFactoryTrait {
        ModelsFactoryTrait::getModelFactory as getModelFactoryFromTrait;
    }

    /**
     * Метод возвращает форму создания сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return CreateFormInterface
     */
    public function getCreateForm(): CreateFormInterface
    {
        return $this->getModelFactory()->getKeywordCreateForm();
    }

    /**
     * Метод возвращает форму удаления сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return DeleteFormInterface
     */
    public function getDeleteForm(): DeleteFormInterface
    {
        return $this->getModelFactory()->getKeywordDeleteForm();
    }

    /**
     * Метод возвращает гидратор фильтра поиска сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return HydratorInterface
     */
    public function getFilterHydrator(): HydratorInterface
    {
        return $this->getModelFactory()->getKeywordFilterHydrator();
    }

    /**
     * Метод возвращает форму поиска списка сущностей "Ключевое фраза".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return ListFormInterface
     */
    public function getListForm(): ListFormInterface
    {
        return $this->getModelFactory()->getKeywordListForm();
    }

    /**
     * Метод возвращает фабрику моделей пакета "Ключевое фраза".
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
     * Метод возвращает форму редатирования сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return UpdateFormInterface
     */
    public function getUpdateForm(): UpdateFormInterface
    {
        return $this->getModelFactory()->getKeywordUpdateForm();
    }

    /**
     * Метод возвращает форму просмотра одной сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Генерируется если фабрика не имплементирует нужный интерфейс.
     *
     * @return ViewFormInterface
     */
    public function getViewForm(): ViewFormInterface
    {
        return $this->getModelFactory()->getKeywordViewForm();
    }
}
