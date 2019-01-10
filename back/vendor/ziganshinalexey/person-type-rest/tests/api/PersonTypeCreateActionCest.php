<?php

declare(strict_types = 1);

namespace Ziganshinalexey\PersonTypeRest\tests;

use Codeception\Util\HttpCode;
use yii;
use Ziganshinalexey\PersonType\entities\PersonTypeActiveRecord;

/**
 * Класс тестирования REST API: создание новой сущности "Тип личности".
 */
class PersonTypeCreateActionCest
{
    /**
     * Метод для послетестовых де-инициализаций.
     *
     * @param ApiTester $i Объект текущего тестировщика.
     *
     * @return void
     */
    public function _after(ApiTester $i): void
    {
    }

    /**
     * Метод для предварительных инициализаций перед тестами.
     *
     * @param ApiTester $i Объект текущего тестировщика.
     *
     * @return void
     */
    public function _before(ApiTester $i): void
    {
        Yii::$app->cache->flush();
        $i->createUser('ApiTester', [
            'password' => 123123,
            'roleId'   => 1,
        ]);
    }

    /**
     * Метод проверяет позитивный кейс.
     *
     * @param ApiTester $i Объект текущего тестировщика.
     *
     * @return void
     */
    public function positiveTest(ApiTester $i): void
    {
        $i->wantTo('Проверить позитивный сценарий - создание сущности "Тип личности"');
        $i->logIn('ApiTester', '123123');
        $request = [
            'name' => sqs('PersonType'),
        ];
        $i->haveHttpHeader('X-HTTP-Method-Override', 'CREATE');
        $i->sendPOST('/api/v1/person-type', $request);
        $i->seeResponseCodeIs(HttpCode::OK);
        $id = $i->grabFromDatabase(Yii::$app->db->schema->getRawTableName(PersonTypeActiveRecord::tableName()), 'id', [
            'name' => sqs('PersonType'),
        ]);
        $i->seeResponseContainsJsonWithThrow([
            'errors'  => [],
            'notices' => [],
            'data'    => [
                'name' => sqs('PersonType'),
                'id'   => $id,
            ],
        ]);
    }
}
