<?php

declare(strict_types = 1);

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Ziganshinalexey\Yii2VkApi\components\GroupComponent;
use Ziganshinalexey\Yii2VkApi\dataTransferObjects\group\Group;
use Ziganshinalexey\Yii2VkApi\factories\GroupFactory;
use Ziganshinalexey\Yii2VkApi\hydrators\GroupDatabaseHydrator;
use Ziganshinalexey\Yii2VkApi\operations\group\MultiFindOperation;

return [
    'class'                                           => GroupComponent::class,
    ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
        'class'                             => GroupFactory::class,
        GroupFactory::MODEL_CONFIG_LIST_KEY => [
            GroupFactory::GROUP_MULTI_FIND_OPERATION => [
                GroupFactory::OBJECT_TYPE_KEY => MultiFindOperation::class,
            ],
            GroupFactory::GROUP_DATABASE_HYDRATOR    => [
                GroupFactory::OBJECT_TYPE_KEY => GroupDatabaseHydrator::class,
            ],
            GroupFactory::GROUP_PROTOTYPE            => [
                GroupFactory::OBJECT_TYPE_KEY => Group::class,
            ],
        ],
    ],
];
