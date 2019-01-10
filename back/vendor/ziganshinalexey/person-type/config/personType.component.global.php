<?php

declare(strict_types = 1);

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\Yii2Cache\caches\operations\SimpleQueryCache;
use Ziganshinalexey\PersonType\components\PersonTypeComponent;
use Ziganshinalexey\PersonType\dataTransferObjects\personType\OperationListResult;
use Ziganshinalexey\PersonType\dataTransferObjects\personType\OperationResult;
use Ziganshinalexey\PersonType\dataTransferObjects\personType\PersonType;
use Ziganshinalexey\PersonType\factories\PersonTypeFactory;
use Ziganshinalexey\PersonType\hydrators\PersonTypeDatabaseHydrator;
use Ziganshinalexey\PersonType\operations\personType\MultiDeleteOperation;
use Ziganshinalexey\PersonType\operations\personType\MultiFindOperation;
use Ziganshinalexey\PersonType\operations\personType\SingleCreateOperation;
use Ziganshinalexey\PersonType\operations\personType\SingleFindOperation;
use Ziganshinalexey\PersonType\operations\personType\SingleUpdateOperation;
use Ziganshinalexey\PersonType\queries\PersonTypeQuery;
use Ziganshinalexey\PersonType\validators\personType\PersonTypeValidator;

return [
    'class'                                           => PersonTypeComponent::class,
    ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
        'class'                                  => PersonTypeFactory::class,
        PersonTypeFactory::MODEL_CONFIG_LIST_KEY => [
            PersonTypeFactory::PERSON_TYPE_OPERATION_RESULT_PROTOTYPE      => [
                PersonTypeFactory::OBJECT_TYPE_KEY => OperationResult::class,
            ],
            PersonTypeFactory::PERSON_TYPE_LIST_OPERATION_RESULT_PROTOTYPE => [
                PersonTypeFactory::OBJECT_TYPE_KEY => OperationListResult::class,
            ],
            PersonTypeFactory::PERSON_TYPE_SINGLE_CREATE_OPERATION         => [
                PersonTypeFactory::OBJECT_TYPE_KEY => SingleCreateOperation::class,
            ],
            PersonTypeFactory::PERSON_TYPE_SINGLE_UPDATE_OPERATION         => [
                PersonTypeFactory::OBJECT_TYPE_KEY => SingleUpdateOperation::class,
            ],
            PersonTypeFactory::PERSON_TYPE_MULTI_DELETE_OPERATION          => [
                PersonTypeFactory::OBJECT_TYPE_KEY => MultiDeleteOperation::class,
            ],
            PersonTypeFactory::PERSON_TYPE_SINGLE_FIND_OPERATION           => [
                PersonTypeFactory::OBJECT_TYPE_KEY => SingleFindOperation::class,
            ],
            PersonTypeFactory::PERSON_TYPE_MULTI_FIND_OPERATION            => [
                PersonTypeFactory::OBJECT_TYPE_KEY => MultiFindOperation::class,
            ],
            PersonTypeFactory::PERSON_TYPE_QUERY                           => [
                PersonTypeFactory::OBJECT_TYPE_KEY => PersonTypeQuery::class,
            ],
            PersonTypeFactory::PERSON_TYPE_DATABASE_HYDRATOR               => [
                PersonTypeFactory::OBJECT_TYPE_KEY => PersonTypeDatabaseHydrator::class,
            ],
            PersonTypeFactory::PERSON_TYPE_CACHE                           => [
                PersonTypeFactory::OBJECT_TYPE_KEY => [
                    'class'     => SimpleQueryCache::class,
                    'keyPrefix' => 'persontype-persontype',
                ],
            ],
            PersonTypeFactory::PERSON_TYPE_PROTOTYPE                       => [
                PersonTypeFactory::OBJECT_TYPE_KEY => PersonType::class,
            ],
            PersonTypeFactory::PERSON_TYPE_VALIDATOR                       => [
                PersonTypeFactory::OBJECT_TYPE_KEY => PersonTypeValidator::class,
            ],
        ],
    ],
];
