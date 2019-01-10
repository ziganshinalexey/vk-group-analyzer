<?php

use Userstory\ComponentBase\interfaces\ComponentWithFactoryInterface;
use Userstory\ComponentBase\models\ModelsFactory;
use Userstory\ComponentBase\queries\ActiveQuery;
use Userstory\ComponentFieldset\components\FieldSetComponent;
use Userstory\ComponentFieldset\entities\Fieldset;
use Userstory\ComponentFieldset\entities\FieldSetting;
use Userstory\ComponentFieldset\factories\ModelFieldSetFactory;

return [
    'controllerMap' => [
        'migrate' => [
            'migrationPathList' => ['@vendor/userstory/component-fieldset/migrations'],
        ],
    ],
    'components'    => [
        'fieldSet' => [
            'class'                                           => FieldSetComponent::class,
            ComponentWithFactoryInterface::FACTORY_CONFIG_KEY => [
                'class'                              => ModelFieldSetFactory::class,
                ModelsFactory::MODEL_CONFIG_LIST_KEY => [
                    'fieldSetQuery'     => [
                        ModelsFactory::OBJECT_TYPE_KEY   => ActiveQuery::class,
                        ModelsFactory::OBJECT_PARAMS_KEY => Fieldset::class,
                    ],
                    'fieldSettingQuery' => [
                        ModelsFactory::OBJECT_TYPE_KEY   => ActiveQuery::class,
                        ModelsFactory::OBJECT_PARAMS_KEY => FieldSetting::class,
                    ],
                ],
            ],
        ],
    ],
];
