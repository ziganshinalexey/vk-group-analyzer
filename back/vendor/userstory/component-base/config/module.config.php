<?php

use Userstory\ComponentBase\formatters\XmlResponseFormatter;
use yii\web\Response;
use Userstory\ComponentBase\components\UploadFileComponent;

return [
    'components' => [
        'uploadFile' => [
            'class' => UploadFileComponent::class,
        ],
        'response'   => [
            'formatters' => [
                Response::FORMAT_XML => XmlResponseFormatter::class,
            ],
        ],
    ],
];
