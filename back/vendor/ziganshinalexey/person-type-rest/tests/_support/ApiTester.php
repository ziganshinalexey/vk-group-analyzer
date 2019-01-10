<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\tests;

use Codeception\Actor;
use UserstoryTest\TagsRest\tests\_generated\ApiTesterActions;

/**
 * Класс текущего актора-тестера.
 */
class ApiTester extends Actor
{
    use ApiTesterActions;

    /**
     * Метод логинит пользователя.
     *
     * @param string $username Имя пользователя.
     * @param string $password Пароль пользователя.
     *
     * @return void
     */
    public function login(string $username, string $password): void
    {
        $this->sendPOST('/api/v1/auth', [
            'login'    => $username,
            'password' => $password,
        ]);
        $this->seeResponseCodeIs(200);
    }
}
