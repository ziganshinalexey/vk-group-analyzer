<?php

declare(strict_types = 1);

return [
    'items' => [
        'admin' => [
            'person-type' => [
                'title'      => 'Типы личностей',
                'icon'       => 'fa fa-sitemap',
                'route'      => '/admin/person-type',
                'permission' => 'Admin.PersonType.PersonType.List',
            ],
        ],
    ],
];
