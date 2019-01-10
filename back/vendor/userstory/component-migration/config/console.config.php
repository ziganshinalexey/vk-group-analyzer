<?php

use Userstory\ComponentMigration\commands\MigrateCommand;
use yii\db\Connection;
use \Userstory\ComponentMigration\components\MigrationComponent;

return [
    'controllerMap' => [
        'migrate' => [
            'class' => MigrateCommand::class,
        ],
    ],
    'components'    => [
        'db'        => [
            'schemaMap' => array_merge((new Connection())->schemaMap, ['pgsql' => 'Userstory\ComponentMigration\models\db\Schema']),
        ],
        'migration' => MigrationComponent::class,
    ],
];
