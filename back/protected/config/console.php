<?php

$config = [
    'id'                  => 'TouchTV Core',
    'basePath'            => dirname(__DIR__),
    'vendorPath'          => dirname(__DIR__, 2) . '/vendor',
    'language'            => 'ru',
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases'             => [
        '@webroot' => dirname(__DIR__, 2) . '/www',
        '@web'     => '',
    ],
];

return $config;
