<?php

declare(strict_types = 1);

use Userstory\ComponentHydrator\formatters\ArrayFormatter;
use Ziganshinalexey\KeywordRest\api\v1\actions\keyword\CreateAction as KeywordCreateAction;
use Ziganshinalexey\KeywordRest\api\v1\actions\keyword\DeleteAction as KeywordDeleteAction;
use Ziganshinalexey\KeywordRest\api\v1\actions\keyword\ListAction as KeywordListAction;
use Ziganshinalexey\KeywordRest\api\v1\actions\keyword\UpdateAction as KeywordUpdateAction;
use Ziganshinalexey\KeywordRest\api\v1\actions\keyword\ViewAction as KeywordViewAction;
use Ziganshinalexey\KeywordRest\api\v1\formatters\keyword\CreateFormatter as KeywordCreateFormatter;
use Ziganshinalexey\KeywordRest\api\v1\formatters\keyword\DeleteFormatter as KeywordDeleteFormatter;
use Ziganshinalexey\KeywordRest\api\v1\formatters\keyword\ListFormatter as KeywordListFormatter;
use Ziganshinalexey\KeywordRest\api\v1\hydrators\keyword\Hydrator as KeywordHydrator;

return [
    'actions' => [
        'v1' => [
            'keyword/create' => [
                'class'     => KeywordCreateAction::class,
                'hydrator'  => KeywordHydrator::class,
                'formatter' => KeywordCreateFormatter::class,
            ],
            'keyword/update' => [
                'class'     => KeywordUpdateAction::class,
                'hydrator'  => KeywordHydrator::class,
                'formatter' => ArrayFormatter::class,
            ],
            'keyword/delete' => [
                'class'     => KeywordDeleteAction::class,
                'formatter' => KeywordDeleteFormatter::class,
            ],
            'keyword/view'   => [
                'class'     => KeywordViewAction::class,
                'formatter' => ArrayFormatter::class,
            ],
            'keyword/index'  => [
                'class'     => KeywordListAction::class,
                'formatter' => KeywordListFormatter::class,
            ],
        ],
    ],
];
