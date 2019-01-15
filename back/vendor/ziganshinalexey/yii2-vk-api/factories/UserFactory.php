<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\factories;

use Userstory\ComponentBase\interfaces\DTOValidatorInterface;
use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Cache\interfaces\QueryCacheInterface;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\OperationListResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\OperationResultInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\FactoryInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\MultiFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleFindOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\SingleUpdateOperationInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\QueryInterface;

/**
 * Фабрика. Реализует породждение моделей пакета для работы с сущностью "ВК пользователь".
 */
class UserFactory extends ModelsFactory implements FactoryInterface
{
    public const USER_PROTOTYPE                       = 'userPrototype';
    public const USER_VALIDATOR                       = 'userValidator';
    public const USER_OPERATION_RESULT_PROTOTYPE      = 'userOperationResultPrototype';
    public const USER_LIST_OPERATION_RESULT_PROTOTYPE = 'userListOperationResultPrototype';
    public const USER_QUERY                           = 'userQuery';
    public const USER_DATABASE_HYDRATOR               = 'userDatabaseHydrator';
    public const USER_SINGLE_CREATE_OPERATION         = 'userSingleCreateOperation';
    public const USER_SINGLE_UPDATE_OPERATION         = 'userSingleUpdateOperation';
    public const USER_SINGLE_FIND_OPERATION           = 'userSingleFindOperation';
    public const USER_MULTI_DELETE_OPERATION          = 'userMultiDeleteOperation';
    public const USER_MULTI_FIND_OPERATION            = 'userMultiFindOperation';
    public const USER_CACHE                           = 'userCache';

    /**
     * Метод возвращает модель кеширования запросов для выборки данных.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return QueryCacheInterface
     */
    protected function getUserCache(): QueryCacheInterface
    {
        return $this->getModelInstance(self::USER_CACHE, [], false);
    }

    /**
     * Метод возвращает модель гидратора для работы с БД.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return HydratorInterface
     */
    protected function getUserDatabaseHydrator(): HydratorInterface
    {
        return $this->getModelInstance(self::USER_DATABASE_HYDRATOR, [], false);
    }

    /**
     * Метод возвращает прототип объекта результата операции над списокм сущностей "ВК пользователь".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return OperationListResultInterface
     */
    public function getUserListOperationResultPrototype(): OperationListResultInterface
    {
        return $this->getModelInstance(static::USER_LIST_OPERATION_RESULT_PROTOTYPE, [], false);
    }

    /**
     * Метод возвращает операцию для удаления нескольких сущности "ВК пользователь".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return MultiDeleteOperationInterface
     */
    public function getUserMultiDeleteOperation(): MultiDeleteOperationInterface
    {
        return $this->getModelInstance(self::USER_MULTI_DELETE_OPERATION, [], false)
                    ->setResultPrototype($this->getUserOperationResultPrototype())
                    ->setCacheModel($this->getUserCache());
    }

    /**
     * Метод возвращает операцию для поиска нескольких сущностей "ВК пользователь".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return MultiFindOperationInterface
     */
    public function getUserMultiFindOperation(): MultiFindOperationInterface
    {
        return $this->getModelInstance(self::USER_MULTI_FIND_OPERATION, [], false)
                    ->setQuery($this->getUserQuery())
                    ->setUserPrototype($this->getUserPrototype())
                    ->setUserDatabaseHydrator($this->getUserDatabaseHydrator())
                    ->setCacheModel($this->getUserCache());
    }

    /**
     * Метод возвращает прототип объекта результата операции над сущностью "ВК пользователь".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return OperationResultInterface
     */
    public function getUserOperationResultPrototype(): OperationResultInterface
    {
        return $this->getModelInstance(static::USER_OPERATION_RESULT_PROTOTYPE, [], false);
    }

    /**
     * Метод возвращает протитип модели DTO сущности "ВК пользователь".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return UserInterface
     */
    public function getUserPrototype(): UserInterface
    {
        return $this->getModelInstance(self::USER_PROTOTYPE, [], false);
    }

    /**
     * Метод возвращает модель построителя запросов для выборки данных.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return QueryInterface
     */
    protected function getUserQuery(): QueryInterface
    {
        return $this->getModelInstance(self::USER_QUERY, [], false);
    }

    /**
     * Метод возвращает операцию для создания одной сущности "ВК пользователь".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return SingleCreateOperationInterface
     */
    public function getUserSingleCreateOperation(): SingleCreateOperationInterface
    {
        return $this->getModelInstance(self::USER_SINGLE_CREATE_OPERATION, [], false)
                    ->setResultPrototype($this->getUserOperationResultPrototype())
                    ->setUserValidator($this->getUserValidator())
                    ->setUserDatabaseHydrator($this->getUserDatabaseHydrator())
                    ->setCacheModel($this->getUserCache());
    }

    /**
     * Метод возвращает операцию для поиска одной сущности "ВК пользователь".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return SingleFindOperationInterface
     */
    public function getUserSingleFindOperation(): SingleFindOperationInterface
    {
        return $this->getModelInstance(self::USER_SINGLE_FIND_OPERATION, [], false)
                    ->setQuery($this->getUserQuery())
                    ->setUserPrototype($this->getUserPrototype())
                    ->setUserDatabaseHydrator($this->getUserDatabaseHydrator())
                    ->setCacheModel($this->getUserCache());
    }

    /**
     * Метод возвращает операцию для обновления одной сущности "ВК пользователь".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return SingleUpdateOperationInterface
     */
    public function getUserSingleUpdateOperation(): SingleUpdateOperationInterface
    {
        return $this->getModelInstance(self::USER_SINGLE_UPDATE_OPERATION, [], false)
                    ->setResultPrototype($this->getUserOperationResultPrototype())
                    ->setUserValidator($this->getUserValidator())
                    ->setUserDatabaseHydrator($this->getUserDatabaseHydrator())
                    ->setCacheModel($this->getUserCache());
    }

    /**
     * Метод возвращает прототип объекта валидатора сущности "ВК пользователь".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return DTOValidatorInterface
     */
    public function getUserValidator(): DTOValidatorInterface
    {
        return $this->getModelInstance(self::USER_VALIDATOR, [], false);
    }
}
