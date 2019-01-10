<?php

declare(strict_types = 1);

use Userstory\ComponentHydrator\formatters\ArrayFormatter;
use Ziganshinalexey\PersonTypeRest\api\v1\actions\personType\CreateAction as PersonTypeCreateAction;
use Ziganshinalexey\PersonTypeRest\api\v1\actions\personType\DeleteAction as PersonTypeDeleteAction;
use Ziganshinalexey\PersonTypeRest\api\v1\actions\personType\ListAction as PersonTypeListAction;
use Ziganshinalexey\PersonTypeRest\api\v1\actions\personType\UpdateAction as PersonTypeUpdateAction;
use Ziganshinalexey\PersonTypeRest\api\v1\actions\personType\ViewAction as PersonTypeViewAction;
use Ziganshinalexey\PersonTypeRest\api\v1\formatters\personType\CreateFormatter as PersonTypeCreateFormatter;
use Ziganshinalexey\PersonTypeRest\api\v1\formatters\personType\DeleteFormatter as PersonTypeDeleteFormatter;
use Ziganshinalexey\PersonTypeRest\api\v1\formatters\personType\ListFormatter as PersonTypeListFormatter;
use Ziganshinalexey\PersonTypeRest\api\v1\hydrators\personType\Hydrator as PersonTypeHydrator;

return [
    'actions' => [
        'v1' => [
            'person-type/create' => [
                'class'     => PersonTypeCreateAction::class,
                'hydrator'  => PersonTypeHydrator::class,
                'formatter' => PersonTypeCreateFormatter::class,
            ],
            'person-type/update' => [
                'class'     => PersonTypeUpdateAction::class,
                'hydrator'  => PersonTypeHydrator::class,
                'formatter' => ArrayFormatter::class,
            ],
            'person-type/delete' => [
                'class'     => PersonTypeDeleteAction::class,
                'formatter' => PersonTypeDeleteFormatter::class,
            ],
            'person-type/view'   => [
                'class'     => PersonTypeViewAction::class,
                'formatter' => ArrayFormatter::class,
            ],
            'person-type/index'  => [
                'class'     => PersonTypeListAction::class,
                'formatter' => PersonTypeListFormatter::class,
            ],
        ],
    ],
];
