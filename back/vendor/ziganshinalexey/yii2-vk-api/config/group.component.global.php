<?php

declare(strict_types = 1);

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\Yii2Cache\caches\operations\SimpleQueryCache;
use Ziganshinalexey\Yii2VkApi\components\GroupComponent;
use Ziganshinalexey\Yii2VkApi\dataTransferObjects\group\Group;
use Ziganshinalexey\Yii2VkApi\dataTransferObjects\group\OperationListResult;
use Ziganshinalexey\Yii2VkApi\dataTransferObjects\group\OperationResult;
use Ziganshinalexey\Yii2VkApi\factories\GroupFactory;
use Ziganshinalexey\Yii2VkApi\hydrators\GroupDatabaseHydrator;
use Ziganshinalexey\Yii2VkApi\operations\group\MultiDeleteOperation;
use Ziganshinalexey\Yii2VkApi\operations\group\MultiFindOperation;
use Ziganshinalexey\Yii2VkApi\operations\group\SingleCreateOperation;
use Ziganshinalexey\Yii2VkApi\operations\group\SingleFindOperation;
use Ziganshinalexey\Yii2VkApi\operations\group\SingleUpdateOperation;
use Ziganshinalexey\Yii2VkApi\queries\GroupQuery;
use Ziganshinalexey\Yii2VkApi\validators\group\GroupValidator;

return [
    'class'                                           => GroupComponent::class,
    ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
        'class'                             => GroupFactory::class,
        GroupFactory::MODEL_CONFIG_LIST_KEY => [
            GroupFactory::GROUP_OPERATION_RESULT_PROTOTYPE      => [
                GroupFactory::OBJECT_TYPE_KEY => OperationResult::class,
            ],
            GroupFactory::GROUP_LIST_OPERATION_RESULT_PROTOTYPE => [
                GroupFactory::OBJECT_TYPE_KEY => OperationListResult::class,
            ],
            GroupFactory::GROUP_SINGLE_CREATE_OPERATION         => [
                GroupFactory::OBJECT_TYPE_KEY => SingleCreateOperation::class,
            ],
            GroupFactory::GROUP_SINGLE_UPDATE_OPERATION         => [
                GroupFactory::OBJECT_TYPE_KEY => SingleUpdateOperation::class,
            ],
            GroupFactory::GROUP_MULTI_DELETE_OPERATION          => [
                GroupFactory::OBJECT_TYPE_KEY => MultiDeleteOperation::class,
            ],
            GroupFactory::GROUP_SINGLE_FIND_OPERATION           => [
                GroupFactory::OBJECT_TYPE_KEY => SingleFindOperation::class,
            ],
            GroupFactory::GROUP_MULTI_FIND_OPERATION            => [
                GroupFactory::OBJECT_TYPE_KEY => MultiFindOperation::class,
            ],
            GroupFactory::GROUP_QUERY                           => [
                GroupFactory::OBJECT_TYPE_KEY => GroupQuery::class,
            ],
            GroupFactory::GROUP_DATABASE_HYDRATOR               => [
                GroupFactory::OBJECT_TYPE_KEY => GroupDatabaseHydrator::class,
            ],
            GroupFactory::GROUP_CACHE                           => [
                GroupFactory::OBJECT_TYPE_KEY => [
                    'class'     => SimpleQueryCache::class,
                    'keyPrefix' => 'yii2vkapi-group',
                ],
            ],
            GroupFactory::GROUP_PROTOTYPE                       => [
                GroupFactory::OBJECT_TYPE_KEY => Group::class,
            ],
            GroupFactory::GROUP_VALIDATOR                       => [
                GroupFactory::OBJECT_TYPE_KEY => GroupValidator::class,
            ],
        ],
    ],
];
