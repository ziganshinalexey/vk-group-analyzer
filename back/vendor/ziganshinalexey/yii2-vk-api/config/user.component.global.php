<?php

declare(strict_types = 1);

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Ziganshinalexey\Yii2VkApi\components\UserComponent;
use Ziganshinalexey\Yii2VkApi\dataTransferObjects\user\User;
use Ziganshinalexey\Yii2VkApi\factories\UserFactory;
use Ziganshinalexey\Yii2VkApi\hydrators\UserDatabaseHydrator;
use Ziganshinalexey\Yii2VkApi\operations\user\MultiFindOperation;

return [
    'class'                                           => UserComponent::class,
    ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
        'class'                            => UserFactory::class,
        UserFactory::MODEL_CONFIG_LIST_KEY => [
            UserFactory::USER_MULTI_FIND_OPERATION => [
                UserFactory::OBJECT_TYPE_KEY => MultiFindOperation::class,
            ],
            UserFactory::USER_DATABASE_HYDRATOR    => [
                UserFactory::OBJECT_TYPE_KEY => UserDatabaseHydrator::class,
            ],
            UserFactory::USER_PROTOTYPE            => [
                UserFactory::OBJECT_TYPE_KEY => User::class,
            ],
        ],
    ],
];
