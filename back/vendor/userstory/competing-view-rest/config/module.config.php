<?php

use Userstory\CompetingViewRest\api\v1\actions\CreateViewAction;
use Userstory\CompetingViewRest\api\v1\actions\GetViewAction;

return [
    'components' => [
        'apiServer' => [
            'actions' => [
                'rules'     => [
                    '[GET] <version>(/<language>)?/<resource>/<entityType>/<id>' => 'api-server/rest-view',
                    '[CREATE] <version>(/<language>)?/<resource>/<entityType>'   => 'api-server/rest-create',
                    '[GET] <version>(/<language>)?/<resource>(/<action>)?'       => 'api-server/rest-index',
                ],
                'v1'        => [
                    'competingView/create' => CreateViewAction::class,
                    'competingView/view'   => GetViewAction::class,
                ],
                'ruleItems' => [
                    'entityType' => '[a-zA-Z]+',
                ],
            ],
        ],
    ],
];
