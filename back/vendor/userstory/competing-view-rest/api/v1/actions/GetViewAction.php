<?php

namespace Userstory\CompetingViewRest\api\v1\actions;

use Userstory\ComponentApiServer\actions\AbstractApiAction;
use yii;

/**
 * Метод апи для получения списка пользователей, которые просматривают сущность.
 *
 * @SWG\Post(
 *     path="/v1/competingView/{entityType}/{entityId}",
 *     tags={"competingView"},
 *     @SWG\Parameter(
 *          type="string",
 *          name="X-HTTP-Method-Override",
 *          in="header",
 *          required=true,
 *          default="GET",
 *     ),
 *     @SWG\Parameter(
 *          type="string",
 *          name="entityType",
 *          in="path",
 *          required=true,
 *          description="тип сущности",
 *     ),
 *     @SWG\Parameter(
 *          type="integer",
 *          name="entityId",
 *          in="path",
 *          required=true,
 *          description="Идентификатор сущности",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Список",
 *         examples={
 *             "errors":{},
 *             "notice":{},
 *             "data":[
 *                  {
 *                      "profileId": 1,
 *                      "firstName": "Admin",
 *                      "lastName": "Admin",
 *                      "secondName": "Admin"
 *                  }
 *              ]
 *         },
 *         @SWG\Schema(
 *             ref="#/definitions/Response",
 *         ),
 *     ),
 * )
 *
 * @package Userstory\ModuleCompetingView\api\v1\actions
 */
class GetViewAction extends AbstractApiAction
{
    /**
     * Метод выполняет действие и возвращает результат.
     *
     * @param array $routeParams Список параметров роута.
     * @param array $queryParams Список параметров строки запроса.
     *
     * @inherit
     *
     * @return array
     */
    public function run(array $routeParams = [], array $queryParams = [])
    {
        /* @var $competingViewComponent \Userstory\CompetingView\components\CompetingViewComponent */
        $competingViewComponent = Yii::$app->competingView;
        $vars = $competingViewComponent->getView($routeParams['entityType'], $routeParams['id']);
        return $competingViewComponent->getHydrator()->extractList($vars);
    }

    /**
     * Метод возвращает пользовательское краткое описание текущего действия.
     *
     * @return array
     */
    public static function info()
    {
        return ['message' => 'Получить данные о просмотрах'];
    }
}
