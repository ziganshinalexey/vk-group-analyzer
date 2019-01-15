<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\factories;

use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Dto\interfaces\results\DtoListResultInterface;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use Ziganshinalexey\Yii2VkApi\interfaces\user\dto\UserInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\FactoryInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\user\operations\MultiFindOperationInterface;

/**
 * Фабрика. Реализует породждение моделей пакета для работы с сущностью "ВК пользователь".
 */
class UserFactory extends ModelsFactory implements FactoryInterface
{
    public const USER_PROTOTYPE                       = 'userPrototype';
    public const USER_LIST_OPERATION_RESULT_PROTOTYPE = 'userListOperationResultPrototype';
    public const USER_DATABASE_HYDRATOR               = 'userDatabaseHydrator';
    public const USER_MULTI_FIND_OPERATION            = 'userMultiFindOperation';
    public const HTTP_CLIENT                          = 'HTTPClient';

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
     * @return DtoListResultInterface
     */
    public function getUserListOperationResultPrototype(): DtoListResultInterface
    {
        return $this->getModelInstance(static::USER_LIST_OPERATION_RESULT_PROTOTYPE, [], false);
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
        /* @var MultiFindOperationInterface $result */
        $result = $this->getModelInstance(self::USER_MULTI_FIND_OPERATION, [], false);

        $result->setDto($this->getUserPrototype());
        $result->setDtoHydrator($this->getUserDatabaseHydrator());
        $result->setResult($this->getUserListOperationResultPrototype());
        $result->setHttpClient($this->getHttpClient());

        return $result;
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
     * Метод возвращает протитип модели DTO сущности "ВК группа".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return Client
     */
    protected function getHttpClient(): Client
    {
        return $this->getModelInstance(self::HTTP_CLIENT, [], false);
    }
}
