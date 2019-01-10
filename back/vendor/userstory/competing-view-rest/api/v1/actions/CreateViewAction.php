<?php

namespace Userstory\CompetingViewRest\api\v1\actions;

use Userstory\ComponentApiServer\actions\AbstractApiAction;
use yii;

/**
 * Метод апи для создание записи о просмотре.
 *
 * @SWG\Post(
 *     path="/v1/competingView/{entityType}",
 *     tags={"competingView"},
 *     @SWG\Parameter(
 *          type="string",
 *          name="X-HTTP-Method-Override",
 *          in="header",
 *          required=true,
 *          default="CREATE",
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
 *          in="formData",
 *          required=true,
 *          description="Идентификатор сущности",
 *     ),
 *     @SWG\Response(
 *         response=200,
 *         description="Сохранено",
 *         examples={
 *             "errors":{},
 *             "notice":{},
 *             "data":{
 *                 "viewDelay": "Время в секундах, по истечению которого информация о просмотре считается устаревшим"
 *             }
 *         },
 *         @SWG\Schema(
 *             ref="#/definitions/Response",
 *         ),
 *     ),
 *     @SWG\Response(
 *         response=403,
 *         description="Доступ к выполнению операции ограничен для текущего пользователя",
 *         examples={
 *              "errors": {{
 *                  "code": 403,
 *                  "title": "Доступ запрещен",
 *                  "detail": "",
 *                  "data": {},
 *              }},
 *              "notice":{},
 *              "data":{}
 *         },
 *         @SWG\Schema(
 *             ref="#/definitions/Response",
 *         ),
 *     ),
 *     @SWG\Response(
 *         response=422,
 *         description="Возникли ошибки при сохранении статьи",
 *         examples={
 *              "errors": {{
 *                  "code": 422,
 *                  "title": "Ошибка сохранения",
 *                  "detail": "",
 *                  "data":""
 *              }},
 *              "notice":{},
 *              "data":{}
 *         },
 *         @SWG\Schema(
 *             ref="#/definitions/Response",
 *         ),
 *     ),
 * )
 *
 * @package Userstory\ModuleCompetingView\api\v1\actions
 */
class CreateViewAction extends AbstractApiAction
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
        if (Yii::$app->user->isGuest || null === Yii::$app->user->getIdentity()) {
            return $this->processAccessError();
        }
        /* @var $competingViewComponent \Userstory\CompetingView\components\CompetingViewComponent */
        $competingViewComponent = Yii::$app->competingView;
        if (! $competingViewComponent->saveView($routeParams['entityType'], Yii::$app->request->post('entityId'))) {
            return $this->processWrongDataError([], 'Ошибка сохранения');
        }
        return ['viewDelay' => $competingViewComponent->viewDelay];
    }

    /**
     * Метод возвращает пользовательское краткое описание текущего действия.
     *
     * @return array
     */
    public static function info()
    {
        return ['message' => 'Создание записи о просмотре'];
    }
}
