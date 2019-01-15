<?php

declare(strict_types = 1);

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\Yii2Cache\caches\operations\SimpleQueryCache;
use Ziganshinalexey\Yii2VkApi\components\UserComponent;
use Ziganshinalexey\Yii2VkApi\dataTransferObjects\user\OperationListResult;
use Ziganshinalexey\Yii2VkApi\dataTransferObjects\user\OperationResult;
use Ziganshinalexey\Yii2VkApi\dataTransferObjects\user\User;
use Ziganshinalexey\Yii2VkApi\factories\UserFactory;
use Ziganshinalexey\Yii2VkApi\hydrators\UserDatabaseHydrator;
use Ziganshinalexey\Yii2VkApi\operations\user\MultiDeleteOperation;
use Ziganshinalexey\Yii2VkApi\operations\user\MultiFindOperation;
use Ziganshinalexey\Yii2VkApi\operations\user\SingleCreateOperation;
use Ziganshinalexey\Yii2VkApi\operations\user\SingleFindOperation;
use Ziganshinalexey\Yii2VkApi\operations\user\SingleUpdateOperation;
use Ziganshinalexey\Yii2VkApi\queries\UserQuery;
use Ziganshinalexey\Yii2VkApi\validators\user\UserValidator;

return [
    'class'                                           => UserComponent::class,
    ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
        'class'                            => UserFactory::class,
        UserFactory::MODEL_CONFIG_LIST_KEY => [
            UserFactory::USER_OPERATION_RESULT_PROTOTYPE      => [
                UserFactory::OBJECT_TYPE_KEY => OperationResult::class,
            ],
            UserFactory::USER_LIST_OPERATION_RESULT_PROTOTYPE => [
                UserFactory::OBJECT_TYPE_KEY => OperationListResult::class,
            ],
            UserFactory::USER_SINGLE_CREATE_OPERATION         => [
                UserFactory::OBJECT_TYPE_KEY => SingleCreateOperation::class,
            ],
            UserFactory::USER_SINGLE_UPDATE_OPERATION         => [
                UserFactory::OBJECT_TYPE_KEY => SingleUpdateOperation::class,
            ],
            UserFactory::USER_MULTI_DELETE_OPERATION          => [
                UserFactory::OBJECT_TYPE_KEY => MultiDeleteOperation::class,
            ],
            UserFactory::USER_SINGLE_FIND_OPERATION           => [
                UserFactory::OBJECT_TYPE_KEY => SingleFindOperation::class,
            ],
            UserFactory::USER_MULTI_FIND_OPERATION            => [
                UserFactory::OBJECT_TYPE_KEY => MultiFindOperation::class,
            ],
            UserFactory::USER_QUERY                           => [
                UserFactory::OBJECT_TYPE_KEY => UserQuery::class,
            ],
            UserFactory::USER_DATABASE_HYDRATOR               => [
                UserFactory::OBJECT_TYPE_KEY => UserDatabaseHydrator::class,
            ],
            UserFactory::USER_CACHE                           => [
                UserFactory::OBJECT_TYPE_KEY => [
                    'class'     => SimpleQueryCache::class,
                    'keyPrefix' => 'yii2vkapi-user',
                ],
            ],
            UserFactory::USER_PROTOTYPE                       => [
                UserFactory::OBJECT_TYPE_KEY => User::class,
            ],
            UserFactory::USER_VALIDATOR                       => [
                UserFactory::OBJECT_TYPE_KEY => UserValidator::class,
            ],
        ],
    ],
];
