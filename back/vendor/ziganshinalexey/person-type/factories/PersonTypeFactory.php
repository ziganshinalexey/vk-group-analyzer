<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonType\factories;

use Userstory\ComponentBase\interfaces\DTOValidatorInterface;
use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Cache\interfaces\QueryCacheInterface;
use yii\base\InvalidConfigException;
use Ziganshinalexey\PersonType\interfaces\personType\dto\OperationListResultInterface;
use Ziganshinalexey\PersonType\interfaces\personType\dto\OperationResultInterface;
use Ziganshinalexey\PersonType\interfaces\personType\dto\PersonTypeInterface;
use Ziganshinalexey\PersonType\interfaces\personType\FactoryInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\MultiFindOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\SingleCreateOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\SingleFindOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\operations\SingleUpdateOperationInterface;
use Ziganshinalexey\PersonType\interfaces\personType\QueryInterface;

/**
 * Фабрика. Реализует породждение моделей пакета для работы с сущностью "Тип личности".
 */
class PersonTypeFactory extends ModelsFactory implements FactoryInterface
{
    public const PERSON_TYPE_PROTOTYPE                       = 'personTypePrototype';
    public const PERSON_TYPE_VALIDATOR                       = 'personTypeValidator';
    public const PERSON_TYPE_OPERATION_RESULT_PROTOTYPE      = 'personTypeOperationResultPrototype';
    public const PERSON_TYPE_LIST_OPERATION_RESULT_PROTOTYPE = 'personTypeListOperationResultPrototype';
    public const PERSON_TYPE_QUERY                           = 'personTypeQuery';
    public const PERSON_TYPE_DATABASE_HYDRATOR               = 'personTypeDatabaseHydrator';
    public const PERSON_TYPE_SINGLE_CREATE_OPERATION         = 'personTypeSingleCreateOperation';
    public const PERSON_TYPE_SINGLE_UPDATE_OPERATION         = 'personTypeSingleUpdateOperation';
    public const PERSON_TYPE_SINGLE_FIND_OPERATION           = 'personTypeSingleFindOperation';
    public const PERSON_TYPE_MULTI_DELETE_OPERATION          = 'personTypeMultiDeleteOperation';
    public const PERSON_TYPE_MULTI_FIND_OPERATION            = 'personTypeMultiFindOperation';
    public const PERSON_TYPE_CACHE                           = 'personTypeCache';

    /**
     * Метод возвращает модель кеширования запросов для выборки данных.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return QueryCacheInterface
     */
    protected function getPersonTypeCache(): QueryCacheInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_CACHE, [], false);
    }

    /**
     * Метод возвращает модель гидратора для работы с БД.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return HydratorInterface
     */
    protected function getPersonTypeDatabaseHydrator(): HydratorInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_DATABASE_HYDRATOR, [], false);
    }

    /**
     * Метод возвращает прототип объекта результата операции над списокм сущностей "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return OperationListResultInterface
     */
    public function getPersonTypeListOperationResultPrototype(): OperationListResultInterface
    {
        return $this->getModelInstance(static::PERSON_TYPE_LIST_OPERATION_RESULT_PROTOTYPE, [], false);
    }

    /**
     * Метод возвращает операцию для удаления нескольких сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return MultiDeleteOperationInterface
     */
    public function getPersonTypeMultiDeleteOperation(): MultiDeleteOperationInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_MULTI_DELETE_OPERATION, [], false)
                    ->setResultPrototype($this->getPersonTypeOperationResultPrototype())
                    ->setCacheModel($this->getPersonTypeCache());
    }

    /**
     * Метод возвращает операцию для поиска нескольких сущностей "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return MultiFindOperationInterface
     */
    public function getPersonTypeMultiFindOperation(): MultiFindOperationInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_MULTI_FIND_OPERATION, [], false)
                    ->setQuery($this->getPersonTypeQuery())
                    ->setPersonTypePrototype($this->getPersonTypePrototype())
                    ->setPersonTypeDatabaseHydrator($this->getPersonTypeDatabaseHydrator())
                    ->setCacheModel($this->getPersonTypeCache());
    }

    /**
     * Метод возвращает прототип объекта результата операции над сущностью "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return OperationResultInterface
     */
    public function getPersonTypeOperationResultPrototype(): OperationResultInterface
    {
        return $this->getModelInstance(static::PERSON_TYPE_OPERATION_RESULT_PROTOTYPE, [], false);
    }

    /**
     * Метод возвращает протитип модели DTO сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return PersonTypeInterface
     */
    public function getPersonTypePrototype(): PersonTypeInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_PROTOTYPE, [], false);
    }

    /**
     * Метод возвращает модель построителя запросов для выборки данных.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return QueryInterface
     */
    protected function getPersonTypeQuery(): QueryInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_QUERY, [], false);
    }

    /**
     * Метод возвращает операцию для создания одной сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return SingleCreateOperationInterface
     */
    public function getPersonTypeSingleCreateOperation(): SingleCreateOperationInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_SINGLE_CREATE_OPERATION, [], false)
                    ->setResultPrototype($this->getPersonTypeOperationResultPrototype())
                    ->setPersonTypeValidator($this->getPersonTypeValidator())
                    ->setPersonTypeDatabaseHydrator($this->getPersonTypeDatabaseHydrator())
                    ->setCacheModel($this->getPersonTypeCache());
    }

    /**
     * Метод возвращает операцию для поиска одной сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return SingleFindOperationInterface
     */
    public function getPersonTypeSingleFindOperation(): SingleFindOperationInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_SINGLE_FIND_OPERATION, [], false)
                    ->setQuery($this->getPersonTypeQuery())
                    ->setPersonTypePrototype($this->getPersonTypePrototype())
                    ->setPersonTypeDatabaseHydrator($this->getPersonTypeDatabaseHydrator())
                    ->setCacheModel($this->getPersonTypeCache());
    }

    /**
     * Метод возвращает операцию для обновления одной сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return SingleUpdateOperationInterface
     */
    public function getPersonTypeSingleUpdateOperation(): SingleUpdateOperationInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_SINGLE_UPDATE_OPERATION, [], false)
                    ->setResultPrototype($this->getPersonTypeOperationResultPrototype())
                    ->setPersonTypeValidator($this->getPersonTypeValidator())
                    ->setPersonTypeDatabaseHydrator($this->getPersonTypeDatabaseHydrator())
                    ->setCacheModel($this->getPersonTypeCache());
    }

    /**
     * Метод возвращает прототип объекта валидатора сущности "Тип личности".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return DTOValidatorInterface
     */
    public function getPersonTypeValidator(): DTOValidatorInterface
    {
        return $this->getModelInstance(self::PERSON_TYPE_VALIDATOR, [], false);
    }
}
