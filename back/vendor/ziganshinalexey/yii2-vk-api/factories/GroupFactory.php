<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Yii2VkApi\factories;

use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Dto\interfaces\results\DtoListResultInterface;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use Ziganshinalexey\Yii2VkApi\interfaces\group\dto\GroupInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\FactoryInterface;
use Ziganshinalexey\Yii2VkApi\interfaces\group\operations\MultiFindOperationInterface;

/**
 * Фабрика. Реализует породждение моделей пакета для работы с сущностью "ВК группа".
 */
class GroupFactory extends ModelsFactory implements FactoryInterface
{
    public const GROUP_PROTOTYPE                       = 'groupPrototype';
    public const GROUP_LIST_OPERATION_RESULT_PROTOTYPE = 'groupListOperationResultPrototype';
    public const GROUP_DATABASE_HYDRATOR               = 'groupDatabaseHydrator';
    public const GROUP_MULTI_FIND_OPERATION            = 'groupMultiFindOperation';
    public const HTTP_CLIENT                           = 'HTTPClient';

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
     * @return DtoListResultInterface
     */
    public function getGroupListOperationResultPrototype(): DtoListResultInterface
    {
        return $this->getModelInstance(static::GROUP_LIST_OPERATION_RESULT_PROTOTYPE, [], false);
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
        /* @var MultiFindOperationInterface $result */
        $result = $this->getModelInstance(self::GROUP_MULTI_FIND_OPERATION, [], false);

        $result->setDto($this->getGroupPrototype());
        $result->setDtoHydrator($this->getGroupDatabaseHydrator());
        $result->setResult($this->getGroupListOperationResultPrototype());
        $result->setHttpClient($this->getHttpClient());

        return $result;
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
