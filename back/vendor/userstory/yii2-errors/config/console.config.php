<?php

declare(strict_types = 1);

use Userstory\Yii2Errors\interfaces\errors\ComponentInterface;

return [
    'components' => [
        ComponentInterface::COMPONENT_KEY => require __DIR__ . '/errors.component.config.php',
    ],
];
