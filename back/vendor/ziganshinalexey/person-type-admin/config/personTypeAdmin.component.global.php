<?php

declare(strict_types = 1);

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Ziganshinalexey\PersonTypeAdmin\components\PersonTypeAdminComponent;
use Ziganshinalexey\PersonTypeAdmin\factories\PersonTypeAdminFactory;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\CreateForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\DeleteForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\FindForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\UpdateForm;
use Ziganshinalexey\PersonTypeAdmin\forms\personType\ViewForm;

return [
    'class'                                           => PersonTypeAdminComponent::class,
    ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
        'class'                                       => PersonTypeAdminFactory::class,
        PersonTypeAdminFactory::MODEL_CONFIG_LIST_KEY => [
            PersonTypeAdminFactory::PERSON_TYPE_CREATE_FORM => [
                PersonTypeAdminFactory::OBJECT_TYPE_KEY => CreateForm::class,
            ],
            PersonTypeAdminFactory::PERSON_TYPE_UPDATE_FORM => [
                PersonTypeAdminFactory::OBJECT_TYPE_KEY => UpdateForm::class,
            ],
            PersonTypeAdminFactory::PERSON_TYPE_DELETE_FORM => [
                PersonTypeAdminFactory::OBJECT_TYPE_KEY => DeleteForm::class,
            ],
            PersonTypeAdminFactory::PERSON_TYPE_FIND_FORM   => [
                PersonTypeAdminFactory::OBJECT_TYPE_KEY => FindForm::class,
            ],
            PersonTypeAdminFactory::PERSON_TYPE_VIEW_FORM   => [
                PersonTypeAdminFactory::OBJECT_TYPE_KEY => ViewForm::class,
            ],
        ],
    ],
];
