<?php

namespace Userstory\CompetingViewRest\tests;

use \Codeception\Actor;

/**
 * Унаследованные методы от хелпера.
 *
 * @method void wantToTest( $text )
 * @method void wantTo( $text )
 * @method void execute( $callable )
 * @method void expectTo( $prediction )
 * @method void expect( $prediction )
 * @method void amGoingTo( $argumentation )
 * @method void am( $role )
 * @method void lookForwardTo( $achieveValue )
 * @method void comment( $description )
 * @method \Codeception\Lib\Friend haveFriend( $name, $actorClass = null )
 */
class ApiTester extends Actor
{
    use _generated\ApiTesterActions;

    /**
     * Метод логинит пользователя.
     *
     * @param string $username Имя пользователя.
     * @param string $password Пароль пользователя.
     *
     * @return void
     */
    public function login($username = 'admin', $password = '123456')
    {
        $this->sendPOST('/v1/auth', [
            'login'    => $username,
            'password' => $password,
        ]);

        $this->seeResponseCodeIs(200);
    }

    /**
     * Метод логаутит пользователя.
     *
     * @return void
     */
    public function logout()
    {
        $this->haveHttpHeader('X-HTTP-Method-Override', 'POST');
        $this->sendPOST('/v1/logout');
        $this->seeResponseCodeIs(200);
    }
}
