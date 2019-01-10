<?php

namespace Userstory\User\Tests;

use Codeception\Actor;

/**
 * Методы, добавляющиеся актёру в тестах.
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
class UnitTester extends Actor
{
    use _generated\UnitTesterActions;
}
