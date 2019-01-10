<?php

namespace Userstory\CompetingView\commands;

use yii;
use yii\base\Action;
use yii\console\Application;
use yii\console\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class ClearCommand.
 * Контроллер консольных команд модуля "Конкурентный просмотр".
 *
 * @package Userstory\CompetingView\commands
 */
class ClearCommand extends Controller
{
    /**
     * Метод для предварительной проверки запроса.
     *
     * @param Action $action Запрошенное действие.
     *
     * @return boolean Выполнять действие или нет.
     *
     * @throws yii\web\NotFoundHttpException Возможное исключение в случае, если запрошена не консольное действие.
     */
    public function beforeAction(Action $action)
    {
        if (! Yii::$app instanceof Application) {
            throw new NotFoundHttpException();
        }

        return parent::beforeAction($action);
    }

    /**
     * Консольная команда по-умолчанию.
     *
     * @return void
     */
    public function actionIndex()
    {
        set_time_limit(0);
        Yii::trace('Start clear old competing views', 'CompetingView');

        Yii::$app->competingView->clearOldViews();

        Yii::trace('Finish clear old competing views', 'CompetingView');
    }
}
