<?php

namespace Userstory\CompetingView\controllers;

use yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Контролер слежения за конкуретным просмотром.
 */
class CompetingviewController extends Controller
{
    /**
     * Единственный метод слежения.
     *
     * @throws NotFoundHttpException    Исключения, если запрос был не через айякс, если не определен юзер, или не указана сущность.
     * @throws yii\base\ExitException   Возможное исключение при завершении приложения.
     *
     * @return void
     */
    public function actionIndex()
    {
        if (! Yii::$app->request->isAjax || Yii::$app->user->isGuest || ! Yii::$app->request->getQueryParam('entityName')) {
            throw new NotFoundHttpException();
        }

        $entityName = Yii::$app->request->getQueryParam('entityName');
        $entityId   = Yii::$app->request->getQueryParam('entityId');

        Yii::$app->competingView->saveView($entityName, $entityId);
        $result = Yii::$app->competingView->findByEntityAndAnotherUser($entityName, $entityId);

        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->data   = $result;
        Yii::$app->end();
    }
}
