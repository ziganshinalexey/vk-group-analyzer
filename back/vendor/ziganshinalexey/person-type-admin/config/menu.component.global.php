<?php

declare(strict_types = 1);

return [
    'items' => [
        'admin' => [
            'person-type' => [
                'title'      => 'Модуль типов личностей (ADMIN-модуль)',
                'icon'       => 'fa fa-sitemap',
                'route'      => '/admin/person-type',
                'permission' => 'Admin.PersonType.PersonType.List',
            ],
        ],
    ],
];
