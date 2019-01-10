<?php

declare(strict_types = 1);

namespace Ziganshinalexey\KeywordRest\tests;

use Codeception\Util\HttpCode;
use yii;
use Ziganshinalexey\Keyword\entities\KeywordActiveRecord;

/**
 * Класс тестирования REST API: создание новой сущности "Ключевое фраза".
 */
class KeywordCreateActionCest
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
        $i->wantTo('Проверить позитивный сценарий - создание сущности "Ключевое фраза"');
        $i->logIn('ApiTester', '123123');
        $request = [
            'text' => sqs('Keyword'),
        ];
        $i->haveHttpHeader('X-HTTP-Method-Override', 'CREATE');
        $i->sendPOST('/api/v1/keyword', $request);
        $i->seeResponseCodeIs(HttpCode::OK);
        $id = $i->grabFromDatabase(Yii::$app->db->schema->getRawTableName(KeywordActiveRecord::tableName()), 'id', [
            'text' => sqs('Keyword'),
        ]);
        $i->seeResponseContainsJsonWithThrow([
            'errors'  => [],
            'notices' => [],
            'data'    => [
                'text' => sqs('Keyword'),
                'id'   => $id,
            ],
        ]);
    }
}
