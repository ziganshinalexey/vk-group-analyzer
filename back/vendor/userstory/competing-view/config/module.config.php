<?php

use Userstory\CompetingView\components\CompetingViewComponent;
use Userstory\CompetingView\controllers\CompetingviewController;
use Userstory\CompetingView\entities\CompetingView;
use Userstory\CompetingView\hydrators\ViewArrayHydrator;
use Userstory\CompetingView\queries\CompetingViewQuery;

return [
    'components'    => [
        'competingView' => [
            'class'           => CompetingViewComponent::class,
            'allowedEntities' => [],
            'viewDelay'       => 60,
            'viewUrl'         => '/compview',
            'modelClasses'    => [
                'main'     => CompetingView::class,
                'query'    => CompetingViewQuery::class,
                'hydrator' => ViewArrayHydrator::class,
            ],
        ],
    ],
    'controllerMap' => [
        'compview' => [
            'class' => CompetingviewController::class,
        ],
    ],
];
