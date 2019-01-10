<?php

declare(strict_types = 1);

namespace Ziganshinalexey\Keyword\factories;

use Userstory\ComponentBase\interfaces\DTOValidatorInterface;
use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\ComponentHydrator\interfaces\HydratorInterface;
use Userstory\Yii2Cache\interfaces\QueryCacheInterface;
use yii\base\InvalidConfigException;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\KeywordInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\OperationListResultInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\dto\OperationResultInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\FactoryInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\MultiDeleteOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\MultiFindOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleCreateOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleFindOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\operations\SingleUpdateOperationInterface;
use Ziganshinalexey\Keyword\interfaces\keyword\QueryInterface;

/**
 * Фабрика. Реализует породждение моделей пакета для работы с сущностью "Ключевое фраза".
 */
class KeywordFactory extends ModelsFactory implements FactoryInterface
{
    public const KEYWORD_PROTOTYPE                       = 'keywordPrototype';
    public const KEYWORD_VALIDATOR                       = 'keywordValidator';
    public const KEYWORD_OPERATION_RESULT_PROTOTYPE      = 'keywordOperationResultPrototype';
    public const KEYWORD_LIST_OPERATION_RESULT_PROTOTYPE = 'keywordListOperationResultPrototype';
    public const KEYWORD_QUERY                           = 'keywordQuery';
    public const KEYWORD_DATABASE_HYDRATOR               = 'keywordDatabaseHydrator';
    public const KEYWORD_SINGLE_CREATE_OPERATION         = 'keywordSingleCreateOperation';
    public const KEYWORD_SINGLE_UPDATE_OPERATION         = 'keywordSingleUpdateOperation';
    public const KEYWORD_SINGLE_FIND_OPERATION           = 'keywordSingleFindOperation';
    public const KEYWORD_MULTI_DELETE_OPERATION          = 'keywordMultiDeleteOperation';
    public const KEYWORD_MULTI_FIND_OPERATION            = 'keywordMultiFindOperation';
    public const KEYWORD_CACHE                           = 'keywordCache';

    /**
     * Метод возвращает модель кеширования запросов для выборки данных.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return QueryCacheInterface
     */
    protected function getKeywordCache(): QueryCacheInterface
    {
        return $this->getModelInstance(self::KEYWORD_CACHE, [], false);
    }

    /**
     * Метод возвращает модель гидратора для работы с БД.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return HydratorInterface
     */
    protected function getKeywordDatabaseHydrator(): HydratorInterface
    {
        return $this->getModelInstance(self::KEYWORD_DATABASE_HYDRATOR, [], false);
    }

    /**
     * Метод возвращает прототип объекта результата операции над списокм сущностей "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return OperationListResultInterface
     */
    public function getKeywordListOperationResultPrototype(): OperationListResultInterface
    {
        return $this->getModelInstance(static::KEYWORD_LIST_OPERATION_RESULT_PROTOTYPE, [], false);
    }

    /**
     * Метод возвращает операцию для удаления нескольких сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return MultiDeleteOperationInterface
     */
    public function getKeywordMultiDeleteOperation(): MultiDeleteOperationInterface
    {
        return $this->getModelInstance(self::KEYWORD_MULTI_DELETE_OPERATION, [], false)
                    ->setResultPrototype($this->getKeywordOperationResultPrototype())
                    ->setCacheModel($this->getKeywordCache());
    }

    /**
     * Метод возвращает операцию для поиска нескольких сущностей "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return MultiFindOperationInterface
     */
    public function getKeywordMultiFindOperation(): MultiFindOperationInterface
    {
        return $this->getModelInstance(self::KEYWORD_MULTI_FIND_OPERATION, [], false)
                    ->setQuery($this->getKeywordQuery())
                    ->setKeywordPrototype($this->getKeywordPrototype())
                    ->setKeywordDatabaseHydrator($this->getKeywordDatabaseHydrator())
                    ->setCacheModel($this->getKeywordCache());
    }

    /**
     * Метод возвращает прототип объекта результата операции над сущностью "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return OperationResultInterface
     */
    public function getKeywordOperationResultPrototype(): OperationResultInterface
    {
        return $this->getModelInstance(static::KEYWORD_OPERATION_RESULT_PROTOTYPE, [], false);
    }

    /**
     * Метод возвращает протитип модели DTO сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return KeywordInterface
     */
    public function getKeywordPrototype(): KeywordInterface
    {
        return $this->getModelInstance(self::KEYWORD_PROTOTYPE, [], false);
    }

    /**
     * Метод возвращает модель построителя запросов для выборки данных.
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return QueryInterface
     */
    protected function getKeywordQuery(): QueryInterface
    {
        return $this->getModelInstance(self::KEYWORD_QUERY, [], false);
    }

    /**
     * Метод возвращает операцию для создания одной сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return SingleCreateOperationInterface
     */
    public function getKeywordSingleCreateOperation(): SingleCreateOperationInterface
    {
        return $this->getModelInstance(self::KEYWORD_SINGLE_CREATE_OPERATION, [], false)
                    ->setResultPrototype($this->getKeywordOperationResultPrototype())
                    ->setKeywordValidator($this->getKeywordValidator())
                    ->setKeywordDatabaseHydrator($this->getKeywordDatabaseHydrator())
                    ->setCacheModel($this->getKeywordCache());
    }

    /**
     * Метод возвращает операцию для поиска одной сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return SingleFindOperationInterface
     */
    public function getKeywordSingleFindOperation(): SingleFindOperationInterface
    {
        return $this->getModelInstance(self::KEYWORD_SINGLE_FIND_OPERATION, [], false)
                    ->setQuery($this->getKeywordQuery())
                    ->setKeywordPrototype($this->getKeywordPrototype())
                    ->setKeywordDatabaseHydrator($this->getKeywordDatabaseHydrator())
                    ->setCacheModel($this->getKeywordCache());
    }

    /**
     * Метод возвращает операцию для обновления одной сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return SingleUpdateOperationInterface
     */
    public function getKeywordSingleUpdateOperation(): SingleUpdateOperationInterface
    {
        return $this->getModelInstance(self::KEYWORD_SINGLE_UPDATE_OPERATION, [], false)
                    ->setResultPrototype($this->getKeywordOperationResultPrototype())
                    ->setKeywordValidator($this->getKeywordValidator())
                    ->setKeywordDatabaseHydrator($this->getKeywordDatabaseHydrator())
                    ->setCacheModel($this->getKeywordCache());
    }

    /**
     * Метод возвращает прототип объекта валидатора сущности "Ключевое фраза".
     *
     * @throws InvalidConfigException Исключение генерируется в случае проблем при создании объекта-модели.
     *
     * @return DTOValidatorInterface
     */
    public function getKeywordValidator(): DTOValidatorInterface
    {
        return $this->getModelInstance(self::KEYWORD_VALIDATOR, [], false);
    }
}
