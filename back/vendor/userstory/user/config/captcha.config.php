<?php

return [
    'db'          => 'dbSqlite',
    'restoreDB'   => true,
    'timeFrame'   => 60 * 10,
    'failsNumber' => 5,
    'enable'      => true,
    'tableName'   => '{{%loginFails}}',
    'action'      => '/login/captcha',
];
