<?php

use Userstory\ModuleAdmin\AdminModule;

return [
    'modules' => [
        'admin' => [
            'class'    => AdminModule::class,
            'loginUrl' => ['/login'],
        ],
    ],
];
