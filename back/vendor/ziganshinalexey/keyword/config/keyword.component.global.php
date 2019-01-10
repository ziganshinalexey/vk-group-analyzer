<?php

declare(strict_types = 1);

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\Yii2Cache\caches\operations\SimpleQueryCache;
use Ziganshinalexey\Keyword\components\KeywordComponent;
use Ziganshinalexey\Keyword\dataTransferObjects\keyword\Keyword;
use Ziganshinalexey\Keyword\dataTransferObjects\keyword\OperationListResult;
use Ziganshinalexey\Keyword\dataTransferObjects\keyword\OperationResult;
use Ziganshinalexey\Keyword\factories\KeywordFactory;
use Ziganshinalexey\Keyword\hydrators\KeywordDatabaseHydrator;
use Ziganshinalexey\Keyword\operations\keyword\MultiDeleteOperation;
use Ziganshinalexey\Keyword\operations\keyword\MultiFindOperation;
use Ziganshinalexey\Keyword\operations\keyword\SingleCreateOperation;
use Ziganshinalexey\Keyword\operations\keyword\SingleFindOperation;
use Ziganshinalexey\Keyword\operations\keyword\SingleUpdateOperation;
use Ziganshinalexey\Keyword\queries\KeywordQuery;
use Ziganshinalexey\Keyword\validators\keyword\KeywordValidator;

return [
    'class'                                           => KeywordComponent::class,
    ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
        'class'                               => KeywordFactory::class,
        KeywordFactory::MODEL_CONFIG_LIST_KEY => [
            KeywordFactory::KEYWORD_OPERATION_RESULT_PROTOTYPE      => [
                KeywordFactory::OBJECT_TYPE_KEY => OperationResult::class,
            ],
            KeywordFactory::KEYWORD_LIST_OPERATION_RESULT_PROTOTYPE => [
                KeywordFactory::OBJECT_TYPE_KEY => OperationListResult::class,
            ],
            KeywordFactory::KEYWORD_SINGLE_CREATE_OPERATION         => [
                KeywordFactory::OBJECT_TYPE_KEY => SingleCreateOperation::class,
            ],
            KeywordFactory::KEYWORD_SINGLE_UPDATE_OPERATION         => [
                KeywordFactory::OBJECT_TYPE_KEY => SingleUpdateOperation::class,
            ],
            KeywordFactory::KEYWORD_MULTI_DELETE_OPERATION          => [
                KeywordFactory::OBJECT_TYPE_KEY => MultiDeleteOperation::class,
            ],
            KeywordFactory::KEYWORD_SINGLE_FIND_OPERATION           => [
                KeywordFactory::OBJECT_TYPE_KEY => SingleFindOperation::class,
            ],
            KeywordFactory::KEYWORD_MULTI_FIND_OPERATION            => [
                KeywordFactory::OBJECT_TYPE_KEY => MultiFindOperation::class,
            ],
            KeywordFactory::KEYWORD_QUERY                           => [
                KeywordFactory::OBJECT_TYPE_KEY => KeywordQuery::class,
            ],
            KeywordFactory::KEYWORD_DATABASE_HYDRATOR               => [
                KeywordFactory::OBJECT_TYPE_KEY => KeywordDatabaseHydrator::class,
            ],
            KeywordFactory::KEYWORD_CACHE                           => [
                KeywordFactory::OBJECT_TYPE_KEY => [
                    'class'     => SimpleQueryCache::class,
                    'keyPrefix' => 'keyword-keyword',
                ],
            ],
            KeywordFactory::KEYWORD_PROTOTYPE                       => [
                KeywordFactory::OBJECT_TYPE_KEY => Keyword::class,
            ],
            KeywordFactory::KEYWORD_VALIDATOR                       => [
                KeywordFactory::OBJECT_TYPE_KEY => KeywordValidator::class,
            ],
        ],
    ],
];
