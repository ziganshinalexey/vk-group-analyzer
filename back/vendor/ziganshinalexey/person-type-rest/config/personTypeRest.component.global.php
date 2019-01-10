<?php

declare(strict_types = 1);

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Ziganshinalexey\PersonType\dataTransferObjects\personType\PersonType;
use Ziganshinalexey\PersonType\filters\personType\MultiFilter;
use Ziganshinalexey\PersonType\validators\personType\PersonTypeFilterValidator;
use Ziganshinalexey\PersonTypeRest\api\v1\forms\personType\CreateForm;
use Ziganshinalexey\PersonTypeRest\api\v1\forms\personType\DeleteForm;
use Ziganshinalexey\PersonTypeRest\api\v1\forms\personType\ListForm;
use Ziganshinalexey\PersonTypeRest\api\v1\forms\personType\UpdateForm;
use Ziganshinalexey\PersonTypeRest\api\v1\forms\personType\ViewForm;
use Ziganshinalexey\PersonTypeRest\api\v1\hydrators\personType\FilterHydrator;
use Ziganshinalexey\PersonTypeRest\api\v1\hydrators\personType\Hydrator;
use Ziganshinalexey\PersonTypeRest\components\PersonTypeRestComponent;
use Ziganshinalexey\PersonTypeRest\factories\PersonTypeRestFactory;

return [
    'class'                                           => PersonTypeRestComponent::class,
    ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
        'class'                                      => PersonTypeRestFactory::class,
        PersonTypeRestFactory::MODEL_CONFIG_LIST_KEY => [
            PersonTypeRestFactory::PERSON_TYPE_CREATE_FORM      => [
                PersonTypeRestFactory::OBJECT_TYPE_KEY => CreateForm::class,
            ],
            PersonTypeRestFactory::PERSON_TYPE_DELETE_FORM      => [
                PersonTypeRestFactory::OBJECT_TYPE_KEY => DeleteForm::class,
            ],
            PersonTypeRestFactory::PERSON_TYPE_LIST_FORM        => [
                PersonTypeRestFactory::OBJECT_TYPE_KEY => ListForm::class,
            ],
            PersonTypeRestFactory::PERSON_TYPE_UPDATE_FORM      => [
                PersonTypeRestFactory::OBJECT_TYPE_KEY => UpdateForm::class,
            ],
            PersonTypeRestFactory::PERSON_TYPE_VIEW_FORM        => [
                PersonTypeRestFactory::OBJECT_TYPE_KEY => ViewForm::class,
            ],
            PersonTypeRestFactory::PERSON_TYPE_FILTER           => [
                PersonTypeRestFactory::OBJECT_TYPE_KEY => MultiFilter::class,
            ],
            PersonTypeRestFactory::PERSON_TYPE_FILTER_VALIDATOR => [
                PersonTypeRestFactory::OBJECT_TYPE_KEY => Person_TypeFilterValidator::class,
            ],
            PersonTypeRestFactory::PERSON_TYPE_FILTER_HYDRATOR  => [
                PersonTypeRestFactory::OBJECT_TYPE_KEY => FilterHydrator::class,
            ],
            PersonTypeRestFactory::PERSON_TYPE_HYDRATOR         => [
                PersonTypeRestFactory::OBJECT_TYPE_KEY => Hydrator::class,
            ],
            PersonTypeRestFactory::PERSON_TYPE_PROTOTYPE        => [
                PersonTypeRestFactory::OBJECT_TYPE_KEY => PersonType::class,
            ],
        ],
    ],
];
