<?php

declare(strict_types = 1);

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\Yii2Errors\components\errors\Component;
use Userstory\Yii2Errors\dataTransferObjects\errors\Collection;
use Userstory\Yii2Errors\dataTransferObjects\errors\Error;
use Userstory\Yii2Errors\factories\errors\Factory;
use Userstory\Yii2Errors\hydrators\errors\CollectionYiiHydrator;
use Userstory\Yii2Errors\iterators\errors\ListIterator;

return [
    'class'                                           => Component::class,
    ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
        'class'                        => Factory::class,
        Factory::MODEL_CONFIG_LIST_KEY => [
            Factory::ERROR_PROTOTYPE                         => [
                Factory::OBJECT_TYPE_KEY => Error::class,
            ],
            Factory::ERROR_COLLECTION_PROTOTYPE              => [
                Factory::OBJECT_TYPE_KEY => Collection::class,
            ],
            Factory::ERROR_LIST_ITERATOR_PROTOTYPE           => [
                Factory::OBJECT_TYPE_KEY => ListIterator::class,
            ],
            Factory::ERROR_COLLECTION_YII_HYDRATOR_PROTOTYPE => [
                Factory::OBJECT_TYPE_KEY => CollectionYiiHydrator::class,
            ],
        ],
    ],
];
