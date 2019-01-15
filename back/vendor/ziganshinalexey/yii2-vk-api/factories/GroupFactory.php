<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\factories;

use Userstory\ComponentBase\interfaces\DTOValidatorInterface;
use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Cache\interfaces\QueryCacheInterface;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\OperationListResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\OperationResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\FactoryInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\MultiFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\SingleFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\SingleUpdateOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\QueryInterface;

/**
 * Фабрика. Реализует породждение моделей пакета для работы с сущностью "ВК группа".
 */
class GroupFactory extends ModelsFactory implements FactoryInterface
{
    public const GROUP_PROTOTYPE                       = 'groupPrototype';
    public const GROUP_VALIDATOR                       = 'groupValidator';
    public const GROUP_OPERATION_RESULT_PROTOTYPE      = 'groupOperationResultPrototype';
    public const GROUP_LIST_OPERATION_RESULT_PROTOTYPE = 'groupListOperationResultPrototype';
    public const GROUP_QUERY                           = 'groupQuery';
    public const GROUP_DATABASE_HYDRATOR               = 'groupDatabaseHydrator';
    public const GROUP_SINGLE_CREATE_OPERATION         = 'groupSingleCreateOperation';
    public const GROUP_SINGLE_UPDATE_OPERATION         = 'groupSingleUpdateOperation';
    public const GROUP_SINGLE_FIND_OPERATION           = 'groupSingleFindOperation';
    public const GROUP_MULTI_DELETE_OPERATION          = 'groupMultiDeleteOperation';
    public const GROUP_MULTI_FIND_OPERATION            = 'groupMultiFindOperation';
    public const GROUP_CACHE                           = 'groupCache';

    /**
     * Метод возвращает модель кеширования запросов для выборки данных.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return QueryCacheInterface
     */
    protected function getGroupCache(): QueryCacheInterface
    {
        return $this->getModelInstance(self::GROUP_CACHE, [], false);
    }

    /**
     * Метод возвращает модель гидратора для работы с БД.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return HydratorInterface
     */
    protected function getGroupDatabaseHydrator(): HydratorInterface
    {
        return $this->getModelInstance(self::GROUP_DATABASE_HYDRATOR, [], false);
    }

    /**
     * Метод возвращает прототип объекта результата операции над списокм сущностей "ВК группа".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return OperationListResultInterface
     */
    public function getGroupListOperationResultPrototype(): OperationListResultInterface
    {
        return $this->getModelInstance(static::GROUP_LIST_OPERATION_RESULT_PROTOTYPE, [], false);
    }

    /**
     * Метод возвращает операцию для удаления нескольких сущности "ВК группа".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return MultiDeleteOperationInterface
     */
    public function getGroupMultiDeleteOperation(): MultiDeleteOperationInterface
    {
        return $this->getModelInstance(self::GROUP_MULTI_DELETE_OPERATION, [], false)
                    ->setResultPrototype($this->getGroupOperationResultPrototype())
                    ->setCacheModel($this->getGroupCache());
    }

    /**
     * Метод возвращает операцию для поиска нескольких сущностей "ВК группа".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return MultiFindOperationInterface
     */
    public function getGroupMultiFindOperation(): MultiFindOperationInterface
    {
        return $this->getModelInstance(self::GROUP_MULTI_FIND_OPERATION, [], false)
                    ->setQuery($this->getGroupQuery())
                    ->setGroupPrototype($this->getGroupPrototype())
                    ->setGroupDatabaseHydrator($this->getGroupDatabaseHydrator())
                    ->setCacheModel($this->getGroupCache());
    }

    /**
     * Метод возвращает прототип объекта результата операции над сущностью "ВК группа".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return OperationResultInterface
     */
    public function getGroupOperationResultPrototype(): OperationResultInterface
    {
        return $this->getModelInstance(static::GROUP_OPERATION_RESULT_PROTOTYPE, [], false);
    }

    /**
     * Метод возвращает протитип модели DTO сущности "ВК группа".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return GroupInterface
     */
    public function getGroupPrototype(): GroupInterface
    {
        return $this->getModelInstance(self::GROUP_PROTOTYPE, [], false);
    }

    /**
     * Метод возвращает модель построителя запросов для выборки данных.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return QueryInterface
     */
    protected function getGroupQuery(): QueryInterface
    {
        return $this->getModelInstance(self::GROUP_QUERY, [], false);
    }

    /**
     * Метод возвращает операцию для создания одной сущности "ВК группа".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return SingleCreateOperationInterface
     */
    public function getGroupSingleCreateOperation(): SingleCreateOperationInterface
    {
        return $this->getModelInstance(self::GROUP_SINGLE_CREATE_OPERATION, [], false)
                    ->setResultPrototype($this->getGroupOperationResultPrototype())
                    ->setGroupValidator($this->getGroupValidator())
                    ->setGroupDatabaseHydrator($this->getGroupDatabaseHydrator())
                    ->setCacheModel($this->getGroupCache());
    }

    /**
     * Метод возвращает операцию для поиска одной сущности "ВК группа".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return SingleFindOperationInterface
     */
    public function getGroupSingleFindOperation(): SingleFindOperationInterface
    {
        return $this->getModelInstance(self::GROUP_SINGLE_FIND_OPERATION, [], false)
                    ->setQuery($this->getGroupQuery())
                    ->setGroupPrototype($this->getGroupPrototype())
                    ->setGroupDatabaseHydrator($this->getGroupDatabaseHydrator())
                    ->setCacheModel($this->getGroupCache());
    }

    /**
     * Метод возвращает операцию для обновления одной сущности "ВК группа".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return SingleUpdateOperationInterface
     */
    public function getGroupSingleUpdateOperation(): SingleUpdateOperationInterface
    {
        return $this->getModelInstance(self::GROUP_SINGLE_UPDATE_OPERATION, [], false)
                    ->setResultPrototype($this->getGroupOperationResultPrototype())
                    ->setGroupValidator($this->getGroupValidator())
                    ->setGroupDatabaseHydrator($this->getGroupDatabaseHydrator())
                    ->setCacheModel($this->getGroupCache());
    }

    /**
     * Метод возвращает прототип объекта валидатора сущности "ВК группа".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return DTOValidatorInterface
     */
    public function getGroupValidator(): DTOValidatorInterface
    {
        return $this->getModelInstance(self::GROUP_VALIDATOR, [], false);
    }
}
